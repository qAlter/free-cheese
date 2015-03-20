onReady(function() {
    if (document.body.children[0].tagName == 'INPUT') {
        var serverAnswer = document.body.children[0];
        if (serverAnswer.name == 'loginned') {
            if (serverAnswer.value == 'true') {
                message('Введенный Вами пароль не верен. Вы хотите восстановить пароль?', 'forgot', 'Вход не выполнен', 'no');
            }
            else {
                message('Такой пользователь не зарегистрирован в системе. Хотите зарегистрироваться?', 'registration', 'Вход не выполнен', 'no');
            }
        }
        else if (serverAnswer.name == 'repass') {
            if (serverAnswer.value == 'true') {
                message('На Ваш E-mail отправлена инструкция по восстановлению пароля!', 'no', 'Успех');
            }
            else {
                message('К сожалению, на Ваш E-mail не получилось отправить письмо. Попробуйте позже.', 'no', 'Ошибка');
            }
        }
        else if (serverAnswer.name == 'activ') {
            if (serverAnswer.value == 'true') {
                message('На указанный Вами e-mail повторно было отправлено письмо с указанием дальнейших действий.', 'index', 'Регистрация почти завершена');
            }
            else {
                message('Что-то не так. Ваш e-mail не подтвержден. Попробуйте зарегистрироваться снова чуть позже.', 'index', 'E-mail не подтвержден');
            }
        }
        else if (serverAnswer.name == 'comment') {
            if (serverAnswer.value == 'true') {
                message('Ваш комментарий отправлен!', 'no', 'Успех');
            }
            else {
                message('К сожалению, Ваш комментарий не отправлен', 'no', 'Отказ');
            }
        }
        else if (serverAnswer.name == 'banned') {
            if (serverAnswer.value == 'true') {
                message('Вы были забанены и розыгрыши Вам больше не доступны! Попробуйте связаться с администраторами, для выяснения причин.', 'no', 'Отказ');
            }
            else {
                message('Администраторы и модераторы лишены возможности участвовать в розыгрышах! Не расстраивайтесь, а лучше порекомендуйте Free-Cheese.com друзьям!', 'no', 'Отказ');
            }
        }
        else if (serverAnswer.name == 'commentDel') {
            if (serverAnswer.value == 'true') {
                message('Ваш комментарий успешно удален!', 'no', 'Успех');
            }
            else if (serverAnswer.value == 'no') {
                message('У Вас нет права удалять этот комментарий!', 'no', 'Отказ');
            }
            else {
                message('К сожалению, произошла ошибка, попробуйте позже', 'no', 'Отказ');
            }
        }
        else if (serverAnswer.name == 'raffles') {
            if (serverAnswer.value == 'true') {
                message('Поздравляем, Ваша заявка принята! Теперь остается только ждать конца розыгрыша!', 'no', 'Успех');
            }
            else {
                message('Ваша заявка на участие в данном розыгрыше отменена.', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'activatedAgain') {
            if (serverAnswer.value == 'true')  {
                message('Ваш e-mail успешно подтвержден', 'user', 'E-mail подтвержден');
            }
            else {
                message('Ваш e-mail не подтвержден, произошла неизвестная ошибка. Попробовать еще раз?', 'activation?again=true', 'E-mail не подтвержден', 'no');
            }
        }
        else if (serverAnswer.name == 'userDo') {
            if (serverAnswer.value == 'true') {
                message('Привелегии пользователя успешно изменены', 'no', 'Успех');
            }
            else {
                message('Пользователь успешно удален', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'userModDo') {
            if (serverAnswer.value == 'true') {
                message('Привелегии пользователя успешно изменены', 'no', 'Успех');
            }
            else {
                message('Вы были забанены за неразрешенные действия', 'no', 'Печально...');
            }
        }
        else if (serverAnswer.name == 'eventCreate') {
            if (serverAnswer.value == 'true') {
                message('Новый розыгрыш успешно создан', 'no', 'Успех');
            }
            else {
                message('Розыгрыш не создан, попробуйте позже', 'no', 'Ошибка');
            }
        }
        else if (serverAnswer.name == 'eventChange') {
            if (serverAnswer.value == 'true') {
                message('Данные розыгрыша успешно изменены', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'eventDelete') {
            if (serverAnswer.value == 'true') {
                message('Розыгрыш успешно удален', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'postCreate') {
            if (serverAnswer.value == 'true') {
                message('Новая запись в блог успешно создана', 'no', 'Успех');
            }
            else {
                message('Запись в блог не создана, попробуйте позже', 'no', 'Ошибка');
            }
        }
        else if (serverAnswer.name == 'postChange') {
            if (serverAnswer.value == 'true') {
                message('Текст записи успешно изменен', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'postDelete') {
            if (serverAnswer.value == 'true') {
                message('Запись успешно удалена из блога', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'newsCreate') {
            if (serverAnswer.value == 'true') {
                message('Новая новость успешно создана', 'no', 'Успех');
            }
            else {
                message('Новость не создана, попробуйте позже', 'no', 'Ошибка');
            }
        }
        else if (serverAnswer.name == 'newsChange') {
            if (serverAnswer.value == 'true') {
                message('Новость успешно изменена', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'newsDelete') {
            if (serverAnswer.value == 'true') {
                message('Новость успешно удалена', 'no', 'Успех');
            }
            else {
                message('Новость успешно удалена', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'nickChange') {
            if (serverAnswer.value == 'true') {
                message('Ваш никнейм успешно изменен', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'avaChange') {
            if (serverAnswer.value == 'true') {
                message('Ваш аватар успешно изменен', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'twitChange') {
            if (serverAnswer.value == 'true') {
                message('Ваш статус успешно изменен', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'passChange') {
            if (serverAnswer.value == 'true') {
                message('Ваш пароль успешно изменен', 'no', 'Успех');
            }
        }
        else if (serverAnswer.name == 'activatedImportant') {
            if (serverAnswer.value == 'true') {
                message('Для смены личных данных необходимо подтвердить свой e-mail, отправить код подтверждения еще раз?', 'activation?again=true', 'E-mail не подтвержден', 'no');
            }
        }
        else if (serverAnswer.name == 'login') {
            if (serverAnswer.value == 'true') {
                message('Для участия в конкурсе необходимо авторизоваться! Перейти к авторизации?', 'login', 'Ошибка', 'no');
            }
        }
        else if (serverAnswer.name == 'articleCreate') {
            if (serverAnswer.value == 'true') {
                message('Новая статья успешно создана', 'no', 'Успех');
            }
            else {
                message('Статья не создана, попробуйте позже', 'no', 'Ошибка');
            }
        }
        else if (serverAnswer.name == 'articleDelete') {
            if (serverAnswer.value == 'true') {
                message('Статья успешно удалена', 'no', 'Успех');
            }
            else {
                message('Статья не удалена, возможно у Вас не хватает прав на это действие.', 'no', 'Ошибка');
            }
        }
        else if (serverAnswer.name == 'articleChange') {
            if (serverAnswer.value == 'true') {
                message('Статья успешно изменена', 'no', 'Успех');
            }
            else if (serverAnswer.value == 'all') {
                message('Статья не изменена, не все поля заполнены.', 'no', 'Ошибка');
            }
            else {
                message('Статья не изменена, возможно у Вас не хватает прав на это действие.', 'no', 'Ошибка');
            }
        }
        else if (serverAnswer.name == 'city') {
            if (serverAnswer.value == 'true') {
                message('Данный розыгрыш не доступен для Вашего местоположения, извините! Для изменения Вашего города свяжитесь с технической поддержкой', 'no', 'Ошибка');
            }
        }
        else if (serverAnswer.name == 'rewrite') {
            if (serverAnswer.value == 'true') {
                message('Текст на странице успешно изменен', 'no', 'Успех');
            }
        }
        else {
            if (serverAnswer.value == 'true') {
                message('На указанный Вами e-mail было отправлено письмо с указанием дальнейших действий', 'index', 'Регистрация почти завершена');
            }
            else {
                message('Вы до сих пор не подтвердили свой e-mail, отправить код подтверждения еще раз?', 'activation?again=true', 'E-mail не подтвержден', 'no');
            }
        }
    }
    if (document.getElementById('loginBlock') != undefined) {
        var loginBlock = document.getElementById('loginBlock'), header = loginBlock.parentNode, userName, selectArray;
        var mind = document.createElement('code');
        if (loginBlock.getElementsByTagName('input').length == 0) {
            userName = loginBlock.getElementsByTagName('a')[0].textContent;
            selectArray = [
                'Да здравствует '+userName+'!',
                'Попасть сюда не сложно, '+userName+'. А выход не могут найти даже старожилы.',
                'Спасибо, что зашли, '+userName+'. А теперь уходите, скорее! Я Вас прикрою!',
                'А Вы пробовали лизать октаэдр, '+userName+'?',
                'С каждой минутой Вы мне нравитесь все больше, '+userName+'!',
                'В наборе детских кубиков буквы «Х», «Й» и «У»<br>всегда находятся на одном кубике, '+userName+'.',
                'Вы тоже имеете право на личную жизнь, '+userName+'.',
                'Высокохохолковый пингвин — это единственный пингвин в мире,<br>который может шевелить своим хохолком.',
                'Жизнь справедлива только к неграм, '+userName+'.',
                'Мне нужна твоя одежда и мотоцикл, '+userName+'.',
                'Приятно проводите время, '+userName+'?',
                'Не верьте тому, что пишут перед вашим псевдонимом, '+userName+'.',
                'Ложки нет',
                'Продолжайте кликать! Во имя всего святого, продолжайте кликать!',
                'Сегодня вас ждёт приятная неожиданность, '+userName+'!',
                'Шоколад ни в чем не виноват, '+userName+'.',
                'Что общего у Майкла Джексона и Нила Армстронга? Лунная походка',
                'Тут никого нет, '+userName+'! Никого!',
                'У вас есть такая проблема, что дерьмо прилипает к шерсти, '+userName+'?'
            ];
        }
        else {
            userName = '%username%';
            selectArray = [
                'Регистрация может решить большинство проблем!',
                'Вы не ошиблись дверью?',
                'Продолжайте кликать! Во имя всего святого, продолжайте кликать!',
                'Знак «HOLLYWOOD» — это реклама недвижимости',
                'Мышь — самое распространённое млекопитающее на Земле',
                'До 1600 термометры наполняли бренди вместо ртути',
                'Кислотный дождь впервые случился в 1852-м году',
                'Новогодние ёлки растут примерно 15 лет, прежде чем поступить в продажу',
                'Самоё дурно пахнущее существо на Земле — это человек',
                'В Гамбурге есть детский сад для мужчин',
                'Глубина Азовского моря всего 14,4 метра',
                '1111111 x 1111111 = 1234567654321',
                '49% американцев не знают, что белый хлеб сделан из пшеницы',
                '22% невест в первую неделю брака сожалеют о своем решении выйти замуж',
                'У новорожденных детей костей больше (300), чем у взрослых (206)'
            ];
        }
        mind.innerHTML = selectArray[getRandomInt(0, selectArray.length-1)];
        header.appendChild(mind);
    }
})