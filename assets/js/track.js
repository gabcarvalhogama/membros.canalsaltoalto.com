/* track.js */
//  window.APP_TRACK = {
//     endpoint: "/track.php",          // ajuste a rota
//     siteId: "meu-site",              // opcional: se tiver multi-domínio/projeto
//     debug: false
//   };
(function () {
  const cfg = window.APP_TRACK || {};
  const ENDPOINT =  "/track/";
  const SITE_ID = "canal-salto-alto";
  const DEBUG = false;

  /* Utils */
  const now = () => Date.now();
  const rnd = () => (crypto?.randomUUID ? crypto.randomUUID() : Math.random().toString(36).slice(2));
  const ls = window.localStorage;
  const ss = window.sessionStorage;

  /* Identidade */
  function getClientId() {
    let id = ls.getItem("trk_cid");
    if (!id) {
      id = rnd();
      ls.setItem("trk_cid", id);
    }
    return id;
  }
  function getSessionId() {
    let sid = ss.getItem("trk_sid");
    let last = Number(ss.getItem("trk_sid_last") || 0);
    const ttl = 30 * 60 * 1000; // 30 minutos
    const t = now();
    if (!sid || t - last > ttl) {
      sid = rnd();
    }
    ss.setItem("trk_sid", sid);
    ss.setItem("trk_sid_last", String(t));
    return sid;
  }

  /* Fila e envio com retry + batch */
  const queue = [];
  let flushTimer = null;

  function enqueue(ev) {
    queue.push(ev);
    if (DEBUG) console.log("[trk] queued", ev.type);
    scheduleFlush(2000);
  }
  function scheduleFlush(delay) {
    if (flushTimer) return;
    flushTimer = setTimeout(flush, delay);
  }
  async function flush() {
    flushTimer = null;
    if (queue.length === 0) return;
    const batch = queue.splice(0, queue.length);
    try {
      await fetch(ENDPOINT, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        keepalive: true,
        body: JSON.stringify({ siteId: SITE_ID, events: batch })
      });
      if (DEBUG) console.log("[trk] sent", batch.length);
    } catch (e) {
      if (DEBUG) console.warn("[trk] send failed, requeue", e);
      queue.unshift(...batch);
      scheduleFlush(5000);
    }
  }
  window.addEventListener("beforeunload", () => {
    if (queue.length) {
      navigator.sendBeacon?.(ENDPOINT, new Blob([JSON.stringify({ siteId: SITE_ID, events: queue })], { type: "application/json" }));
    }
  });

  /* Contexto base do evento */
  function baseCtx() {
    return {
      ts: now(),
      url: location.href,
      path: location.pathname,
      ref: document.referrer || null,
      ua: navigator.userAgent,
      lang: navigator.language,
      vw: window.innerWidth,
      vh: window.innerHeight,
      cid: getClientId(),
      sid: getSessionId()
    };
  }

  /* Pageview + tempo ativo */
  let lastActivity = now();
  let activeMs = 0;
  const ACTIVITY_THROTTLE = 5000;

  ["mousemove", "keydown", "scroll", "touchstart"].forEach(evt => {
    window.addEventListener(evt, () => {
      const t = now();
      if (t - lastActivity > ACTIVITY_THROTTLE) {
        activeMs += t - lastActivity;
        lastActivity = t;
      }
    }, { passive: true });
  });

  function trackPageview() {
    enqueue({ type: "pageview", ...baseCtx(), title: document.title });
  }

  /* Scroll depth */
  let maxScroll = 0;
  window.addEventListener("scroll", () => {
    const scrolled = (window.scrollY + window.innerHeight) / Math.max(document.body.scrollHeight, window.innerHeight);
    const pct = Math.round(scrolled * 100);
    if (pct > maxScroll) {
      maxScroll = pct;
      if ([25, 50, 75, 90, 100].includes(pct)) {
        enqueue({ type: "scroll", ...baseCtx(), percent: pct });
      }
    }
  }, { passive: true });

  /* Heartbeat a cada 15s com tempo ativo aproximado */
  setInterval(() => {
    const t = now();
    activeMs += t - lastActivity;
    lastActivity = t;
    enqueue({ type: "heartbeat", ...baseCtx(), activeMs });
    activeMs = 0;
  }, 15000);

  /* Expor API global para eventos custom */
  window.TRACK = {
    event: function (name, data) {
      enqueue({ type: "event", name, data: data || null, ...baseCtx() });
    },
    identify: function (userId, traits) {
      ls.setItem("trk_uid", userId);
      if (traits) ls.setItem("trk_traits", JSON.stringify(traits));
      enqueue({ type: "identify", userId, traits: traits || null, ...baseCtx() });
    },
    getIds: function () {
      return { cid: getClientId(), sid: getSessionId(), uid: ls.getItem("trk_uid") || null };
    }
  };

  /* Captura de mudanças de rota em SPAs (history API) */
  const pushState = history.pushState;
  const replaceState = history.replaceState;
  function onRouteChange() {
    maxScroll = 0;
    trackPageview();
  }
  history.pushState = function () { pushState.apply(this, arguments); onRouteChange(); };
  history.replaceState = function () { replaceState.apply(this, arguments); onRouteChange(); };
  window.addEventListener("popstate", onRouteChange);

  /* Pageview inicial */
  trackPageview();
})();
