window.onload = function() {
    const lookupBtn = document.getElementById("lookup");
    const lookupCitiesBtn = document.getElementById("lookup-cities"); // <-- added
    const resultDiv = document.getElementById("result");
    const countryInput = document.getElementById("country");

    lookupBtn.addEventListener("click", function(e) {
        e.preventDefault();

        const country = countryInput.value.trim();
        const url = "world.php?country=" + encodeURIComponent(country);

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(() => {
                resultDiv.innerHTML = "<p>Error fetching data.</p>";
            });
    });

    lookupCitiesBtn.addEventListener("click", function(e) {
        e.preventDefault();

        const country = countryInput.value.trim();
        const url = "world.php?lookup=cities&country=" + encodeURIComponent(country);

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(() => {
                resultDiv.innerHTML = "<p>Error fetching city data.</p>";
            });
    });
};
