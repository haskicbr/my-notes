$(function () {
    
    var form = new CardForm();
    console.log(form.validate());
    console.log(form.errorsString);

    $('[name = "card-number[]"], [name = card-cvs]').on('keydown', function (e) {

        $el = $(this);

        if (!e.key.match(/[0-9]/) && e.key != "Backspace") {
            $('.notify-container').notify('номер карты и CVC код должны содержать только цифры');
            return false;
        }

    }).on('keyup', function () {

        if ($el.val().length == 4) {
            $el.next().focus();
        }
    });

    $('[name = "card-number[]"]:nth-child(2)').on('keyup', function(){
        getCardType($(this).val());
    });

    $('.card-name').on('keydown',function(e){

        $el = $(this);

        if (!e.key.match(/[А-яA-z]/) && e.key != "Backspace") {
            $('.notify-container').notify("ФИО должны содеражть только буквы");
            return false;
        }

    }).on('keyup', function () {
        $el.val($.fn.Translit($el.val()))
    });


    $('#confirm').on('click', function (e) {

        form.attributes.cardCvc.value =  $('[name = card-cvs]').val();

        var cardNumber = '';
        $('[name = "card-number[]"]').each(function(key,el){
            cardNumber += $(el).val();
        });

        attributes = form.attributes;

        attributes.cardNumber.value = cardNumber;
        attributes.name.value = $('[name = "first-name"]').val();
        attributes.lastName.value = $('[name = "last-name"]').val();
        attributes.middleName.value = $('[name = "middle-name"]').val();
        attributes.cardEndMonth.value = $('[name = "card-month-end"]').val();
        attributes.cardEndYear.value = $('[name = "card-year-end"]').val();


        if(form.validate()) {
            console.log('send request server');
        } else {
           $('.notify-container').notify(form.errorsString,5000);
        }
        
        e.preventDefault();
    });

});
