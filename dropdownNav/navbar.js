$(document).ready(function () {

    console.log("ready");


    let listElement = $('header .nav.navbar-nav>.menu-item-has-children');

    if (window.outerWidth < 992) {
        listElement.click(function (_event) {
            console.log("clicked funni li");
            console.log(_event, _event.target, $(_event.target).children('.sub-menu'));
            $(_event.target).children('.sub-menu').slideToggle();
        });
    }
});
