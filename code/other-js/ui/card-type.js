//Мир - 2. VISA – 4; American Express – 3, MasterCard – 5, Maestro - 3, 5 или 6, JCB International - 3, China UnionPay - 6, УЭК - 7,
cardTypes = {
    visa: {
        value: 4,
        image: '<img class="card-logo" src="https://www.seeklogo.net/wp-content/uploads/2013/06/visa-inc-vector-logo-400x400.png" />'
    },
    mastercard: {
        value: 5,
        image: '<img class="card-logo" src="http://seeklogo.com/images/M/mastercard-logo-0B2A04833C-seeklogo.com.png"/>'
    },
    mir: {
        value: 2,
        image: '<img class="card-logo" src="http://bosfera.ru/sites/default/files/styles/280_233sc/public/mir_new_10.png?itok=rPt2mgdW"/>'
    },
    ae: {
        value: 3,
        image: '<img class="card-logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/American_Express_logo.svg/300px-American_Express_logo.svg.png" />'
    }

    /* all types */
};

function getCardType(value) {

    if (value.length > 0) {
        value = parseInt(value.split('')[0]);
        if (value) {

            $el = $('#card-type');

            $el.show().html('');

            for (key in cardTypes) {
                if (cardTypes[key].value == value) {
                    $el.show().html(cardTypes[key].image);
                }
            }
        }
    }

    return false;
}