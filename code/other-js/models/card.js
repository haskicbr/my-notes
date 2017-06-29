var CardForm = function () {
    
    this.errorsString = '';

    var self = this;
    
    this.attributes = {

        name: {
            value: '',
            title: 'имя'
        },
        lastName: {
            value: '',
            title: 'фамилия'
        },
        middleName: {
            value: '',
            title: 'отчество'
        },
        cardNumber: {
            value: '',
            title: 'номер карты'
        },
        cardCvc: {
            value: '',
            title: 'cvc код'
        },
        cardEndYear: {
            value: '',
            title: 'год окончания действия карты'
        },
        cardEndMonth: {
            value: '',
            title: 'месяц окончания действия карты'
        }
    };
    
    this.validate = function() {


        this.errorsString = '';

        if(self.attributes.name.value.length < 1){
            self.errorsString += 'Заполните имя; '
        }

        if(self.attributes.lastName.value.length < 1){
            self.errorsString += 'Заполните фамилию; '
        }

        if(self.attributes.middleName.value.length < 1){
            self.errorsString += 'Заполните отчество; '
        }

        if(self.attributes.cardNumber.value.length < 16){
            self.errorsString += 'Заполните номер карты; '
        }

        if(self.attributes.cardCvc.value.length < 4){
            self.errorsString += 'Заполните номер CVC; '
        }
        
        if(self.errorsString.length == 0) {
            return true;
        } else {
            return false;
        }
    };
    
    return this;
};