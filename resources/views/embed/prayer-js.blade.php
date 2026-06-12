(function () {
    var container = document.getElementById("prayer-widget");

    if (!container) return;

    container.innerHTML = `
        <div style="border:1px solid #ddd;padding:10px;font-family:Arial">
            <h4>Prayer Times – {{ $city }}</h4>
            <div id="times">Loading...</div>
            <small>
                Powered by 
                <a href="https://YOURDOMAIN.com" target="_blank">Prayer Time API</a>
            </small>
        </div>
    `;

    fetch("https://api.aladhan.com/v1/timingsByCity?city={{ $city }}&country={{ $country }}&method=1")
        .then(res => res.json())
        .then(data => {
            let t = data.data.timings;
            document.getElementById("times").innerHTML = `
                Fajr: ${t.Fajr}<br>
                Dhuhr: ${t.Dhuhr}<br>
                Asr: ${t.Asr}<br>
                Maghrib: ${t.Maghrib}<br>
                Isha: ${t.Isha}
            `;
        });
})();