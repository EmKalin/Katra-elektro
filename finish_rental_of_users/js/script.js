function smoothScroll(element) {
    document.querySelector(element).scrollIntoView({
        behavior: "smooth"

    });
}

function reserve(narzedzia) {
    var select = document.getElementById('narzedzia');
    var options_selected = select.querySelectorAll('option[selected]');


    options_selected.forEach(function (option) {
        option.removeAttribute("selected");
    });


    var option = select.querySelector('option[value="'+narzedzia+'"]');

    option.setAttribute("selected","selected");
    smoothScroll('#reservation');
}

function calculate(price) {
    var result = document.getElementById('amount');
    result.innerHTML = '';
    var days = document.getElementById('days').value;

    var cost = days*price;

    result.innerHTML = cost;
}

function calculate_price(price) {

    document.getElementById('days').addEventListener('change', function () {
        calculate(price);
    })

}