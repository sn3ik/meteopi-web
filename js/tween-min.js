function Delegate() {}
Delegate.create = function(n, t) {
    for (var r = [], u = arguments.length, i = 2; i < u; i++) r[i - 2] = arguments[i];
    return function() {
        var i = [].concat(arguments, r);
        t.apply(n, i)
    }
}, Tween = function(n, t, i, r, u, f, e) {
    this.init(n, t, i, r, u, f, e)
};
var t = Tween.prototype;
t.obj = {}, t.prop = "", t.func = function(n, t, i, r) {
    return i * n / r + t
}, t.begin = 0, t.change = 0, t.prevTime = 0, t.prevPos = 0, t.looping = !1, t._duration = 0, t._time = 0, t._pos = 0, t._position = 0, t._startTime = 0, t._finish = 0, t.name = "", t.suffixe = "", t._listeners = [], t.setTime = function(n) {
    this.prevTime = this._time, n > this.getDuration() ? this.looping ? (this.rewind(n - this._duration), this.update(), this.broadcastMessage("onMotionLooped", {
        target: this,
        type: "onMotionLooped"
    })) : (this._time = this._duration, this.update(), this.stop(), this.broadcastMessage("onMotionFinished", {
        target: this,
        type: "onMotionFinished"
    })) : n < 0 ? (this.rewind(), this.update()) : (this._time = n, this.update())
}, t.getTime = function() {
    return this._time
}, t.setDuration = function(n) {
    this._duration = n === null || n <= 0 ? 1e5 : n
}, t.getDuration = function() {
    return this._duration
}, t.setPosition = function(n) {
    this.prevPos = this._pos;
    var t = this.suffixe !== "" ? this.suffixe : "";
    this.obj[this.prop] = Math.round(n) + t, this._pos = n, this.broadcastMessage("onMotionChanged", {
        target: this,
        type: "onMotionChanged"
    })
}, t.getPosition = function(n) {
    return n === undefined && (n = this._time), this.func(n, this.begin, this.change, this._duration)
}, t.setFinish = function(n) {
    this.change = n - this.begin
}, t.getFinish = function() {
    return this.begin + this.change
}, t.init = function(n, t, i, r, u, f, e) {
    arguments.length && (this._listeners = [], this.addListener(this), e && (this.suffixe = e), this.obj = n, this.prop = t, this.begin = r, this._pos = r, this.setDuration(f), i !== null && i !== "" && (this.func = i), this.setFinish(u))
}, t.start = function() {
    this.rewind(), this.startEnterFrame(), this.broadcastMessage("onMotionStarted", {
        target: this,
        type: "onMotionStarted"
    })
}, t.rewind = function(n) {
    this.stop(), this._time = n === undefined ? 0 : n, this.fixTime(), this.update()
}, t.fforward = function() {
    this._time = this._duration, this.fixTime(), this.update()
}, t.update = function() {
    this.setPosition(this.getPosition(this._time))
}, t.startEnterFrame = function() {
    this.stopEnterFrame(), this.isPlaying = !0, this.onEnterFrame()
}, t.onEnterFrame = function() {
    this.isPlaying && (this.nextFrame(), setTimeout(Delegate.create(this, this.onEnterFrame), 25))
}, t.nextFrame = function() {
    this.setTime((this.getTimer() - this._startTime) / 1e3)
}, t.stop = function() {
    this.stopEnterFrame(), this.broadcastMessage("onMotionStopped", {
        target: this,
        type: "onMotionStopped"
    })
}, t.stopEnterFrame = function() {
    this.isPlaying = !1
}, t.playing = function() {
    return isPlaying()
}, t.continueTo = function(n, t) {
    this.begin = this._pos, this.setFinish(n), this._duration !== undefined && this.setDuration(t), this.start()
}, t.resume = function() {
    this.fixTime(), this.startEnterFrame(), this.broadcastMessage("onMotionResumed", {
        target: this,
        type: "onMotionResumed"
    })
}, t.yoyo = function() {
    this.continueTo(this.begin, this._time)
}, t.addListener = function(n) {
    return this.removeListener(n), this._listeners.push(n)
}, t.removeListener = function(n) {
    for (var t = this._listeners, i = t.length; i--;)
        if (t[i] === n) return t.splice(i, 1), !0;
    return !1
}, t.broadcastMessage = function() {
    for (var i = [], r, t = this._listeners, u = t.length, n = 0; n < arguments.length; n++) i.push(arguments[n]);
    for (r = i.shift(), n = 0; n < u; n++) t[n][r] && t[n][r].apply(t[n], i)
}, t.fixTime = function() {
    this._startTime = this.getTimer() - this._time * 1e3
}, t.getTimer = function() {
    return +new Date - this._time
}, Tween.backEaseIn = function(n, t, i, r) {
    var e = 1.70158;
    return i * (n /= r) * n * ((e + 1) * n - e) + t
}, Tween.backEaseOut = function(n, t, i, r) {
    var e = 1.70158;
    return i * ((n = n / r - 1) * n * ((e + 1) * n + e) + 1) + t
}, Tween.backEaseInOut = function(n, t, i, r) {
    var e = 1.70158;
    return (n /= r / 2) < 1 ? i / 2 * n * n * (((e *= 1.525) + 1) * n - e) + t : i / 2 * ((n -= 2) * n * (((e *= 1.525) + 1) * n + e) + 2) + t
}, Tween.elasticEaseIn = function(n, t, i, r, u, f) {
    var e;
    return n === 0 ? t : (n /= r) == 1 ? t + i : (f || (f = r * .3), !u || u < Math.abs(i) ? (u = i, e = f / 4) : e = f / (2 * Math.PI) * Math.asin(i / u), -(u * Math.pow(2, 10 * (n -= 1)) * Math.sin((n * r - e) * 2 * Math.PI / f)) + t)
}, Tween.elasticEaseOut = function(n, t, i, r, u, f) {
    var e;
    return n === 0 ? t : (n /= r) == 1 ? t + i : (f || (f = r * .3), !u || u < Math.abs(i) ? (u = i, e = f / 4) : e = f / (2 * Math.PI) * Math.asin(i / u), u * Math.pow(2, -10 * n) * Math.sin((n * r - e) * 2 * Math.PI / f) + i + t)
}, Tween.elasticEaseInOut = function(n, t, i, r, u, f) {
    var e;
    return n === 0 ? t : (n /= r / 2) == 2 ? t + i : (f || (f = r * .3 * 1.5), !u || u < Math.abs(i) ? (u = i, e = f / 4) : e = f / (2 * Math.PI) * Math.asin(i / u), n < 1) ? -.5 * u * Math.pow(2, 10 * (n -= 1)) * Math.sin((n * r - e) * 2 * Math.PI / f) + t : u * Math.pow(2, -10 * (n -= 1)) * Math.sin((n * r - e) * 2 * Math.PI / f) * .5 + i + t
}, Tween.bounceEaseOut = function(n, t, i, r) {
    return (n /= r) < 1 / 2.75 ? i * 7.5625 * n * n + t : n < 2 / 2.75 ? i * (7.5625 * (n -= 1.5 / 2.75) * n + .75) + t : n < 2.5 / 2.75 ? i * (7.5625 * (n -= 2.25 / 2.75) * n + .9375) + t : i * (7.5625 * (n -= 2.625 / 2.75) * n + .984375) + t
}, Tween.bounceEaseIn = function(n, t, i, r) {
    return i - Tween.bounceEaseOut(r - n, 0, i, r) + t
}, Tween.bounceEaseInOut = function(n, t, i, r) {
    return n < r / 2 ? Tween.bounceEaseIn(n * 2, 0, i, r) * .5 + t : Tween.bounceEaseOut(n * 2 - r, 0, i, r) * .5 + i * .5 + t
}, Tween.strongEaseInOut = function(n, t, i, r) {
    return i * (n /= r) * n * n * n * n + t
}, Tween.regularEaseIn = function(n, t, i, r) {
    return i * (n /= r) * n + t
}, Tween.regularEaseOut = function(n, t, i, r) {
    return -i * (n /= r) * (n - 2) + t
}, Tween.regularEaseInOut = function(n, t, i, r) {
    return (n /= r / 2) < 1 ? i / 2 * n * n + t : -i / 2 * (--n * (n - 2) - 1) + t
}, Tween.strongEaseIn = function(n, t, i, r) {
    return i * (n /= r) * n * n * n * n + t
}, Tween.strongEaseOut = function(n, t, i, r) {
    return i * ((n = n / r - 1) * n * n * n * n + 1) + t
}, Tween.strongEaseInOut = function(n, t, i, r) {
    return (n /= r / 2) < 1 ? i / 2 * n * n * n * n * n + t : i / 2 * ((n -= 2) * n * n * n * n + 2) + t
}
