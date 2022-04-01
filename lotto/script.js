$(document).ready(function () {

    let prefix;
    const end = ".png";
    let womenUrls = [];
    const html = document.querySelector("html");

    calculateSize();
    window.addEventListener("resize", calculateSize);
    let random = Math.round(Math.random() * (6 - 1) + 1);

    function preload(_Urls) {
        $(_Urls).each(function () {
            $("<img />").attr("src", this).addClass("woman").appendTo("#sleeve").hide();
        });
    }
    preload(womenUrls);
    let current;

    $(".woman").filter(`[src='${womenUrls[random]}']`).fadeIn(2000, function () {
        current = $(".woman").filter(":visible");
    });

    setInterval(changeImg, 5000);

    function changeImg() {
        let newRandom;
        do {
            newRandom = Math.round(Math.random() * (6 - 1) + 1)
        } while (newRandom == random);
        console.log(random, newRandom);
        random = newRandom;

        current.fadeOut(2000);
        $(".woman").filter(`[src*='${random}']`).attr("src", prefix + random + end).fadeIn(2000, function () {
            current = $(".woman").filter(":visible");
        });
    }

    function calculateSize() {
        if (html.clientWidth < 640) {
            prefix = "./style/power-women/mobile/power-frau-";
            console.log("using mobile images!");
        }
        else if (html.clientWidth < 1007) {
            prefix = "./style/power-women/tablet/power-frau-";
            console.log("using tablet images!");
        }
        else {
            prefix = "./style/power-women/power-frau-";
            console.log("using desktop images!");
        }
        womenUrls = [];
        for (let i = 1; i < 7; i++) {
            womenUrls.push(prefix + i + end)
        }
    }
});