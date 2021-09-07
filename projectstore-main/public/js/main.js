
document.body.addEventListener("click", function (event) {
    const approvalCross = event.target.closest('.approval-form .cross');
    if (approvalCross) {
        approvalForm = approvalCross.closest(".approval-form");
        approvalForm.style.display = (window.getComputedStyle(approvalForm).display == 'none') ? 'block' : '';
    }
});

if (document.querySelector('.header__auth-img')) {
    document.querySelector('.header__auth-img').onclick = function() {
        let authWindow = document.querySelector('.header__right > .auth:last-child');
        let restoreWindow = document.querySelector('.header__right > .auth-restore');
        let authCross = authWindow.querySelector(".cross");
        let authForgetLink = authWindow.querySelector('.auth__forget-link');
        let restoreCross = restoreWindow.querySelector(".cross");

        authWindow.style.display = (window.getComputedStyle(authWindow).display == 'none') ? 'block' : 'none';
        restoreWindow.style.display = (window.getComputedStyle(restoreWindow).display == 'block') ? 'none' : '';
        authCross.onclick = function() {
            authWindow.style.display = (window.getComputedStyle(authWindow).display == 'none') ? 'block' : 'none';
        };

        restoreCross.onclick = function() {
            restoreWindow.style.display = (window.getComputedStyle(restoreWindow).display == 'none') ? 'block' : 'none';
        }

        authForgetLink.onclick = function(event) {
            event.preventDefault();
            authWindow.style.display = (window.getComputedStyle(authWindow).display == 'none') ? 'block' : 'none';
            restoreWindow.style.display = (window.getComputedStyle(restoreWindow).display == 'none') ? 'block' : 'none';
        }
    }
}

function getCoords(elem) {
    let box = elem.getBoundingClientRect();

    return {
        top: box.top + pageYOffset,
        left: box.left + pageXOffset
    };
}

const approveHref = '/admin/expertise/approve';
const approval_id = document.querySelector(".approval-form__id b"),
    approval_a = document.querySelector(".approval-form__approve"),
    approval_input = document.querySelector("[name=project_id]"),
    approval_form = document.querySelector(".approval-form");
document.body.addEventListener("click", function(e){
    const button = e.target.closest(".open-project__approval");
    if(!button){return};
    // добавил
    e.preventDefault();
    // const row = button.closest(".row").getBoundingClientRect().top;
    // var c = this.getBoundingClientRect(),
    //     scrolltop = document.body.scrollTop + c.top,
    //     scrollleft = document.body.scrollLeft + c.left;
    const id = button.closest(".row").querySelector(".open-project__id").textContent;
    approval_id.textContent = id;
    approval_a.href = `${approveHref}/${id}`; // ну или как там было
    approval_input.value = id;
    approval_form.style.display = "block";
    approval_form.style.top = getCoords(button.closest(".row")).top + -115 + "px";
    // approval_form.style.left = getCoords(button.closest(".row")).left + 405 + "px";
})



if (document.querySelector('.header__triangle')) {
    document.querySelector('.header__triangle').onclick = function () {
        this.classList.toggle('header__triangle_side')
        let profileWindow = document.querySelector('.profile-window')
        profileWindow.style.display = (profileWindow.style.display == '') ? 'block' : ''
    }
}

if(document.querySelector('.performers__edit-places-triangle')) {
    document.querySelector('.performers__edit-places-triangle').onclick = function () {
        this.classList.toggle('header__triangle_side');
    }
}

document.body.addEventListener("click", function (event) {
    const elem = event.target.closest(".candidate-card__triangle");
    if (elem) {
        elem.classList.toggle("triangle_side");
        const window = elem.closest(".candidate-card").querySelector(".candidate-card__change-window");
        window.classList.toggle("candidate-card__change-window_active");
    }
});





// focus(blur),input events on search

if (document.querySelector(".search-form__field")) {
    for (let event of ["focus", "input"]) {
        document.querySelector(".search-form__field").addEventListener(event, () => {
            document.querySelector(".search-form__path").style.strokeOpacity = "1";
        });
    }
    document
        .querySelector(".search-form__field")
        .addEventListener("blur", function () {
            if (this.value.trim() == "") {
                document.querySelector(".search-form__path").style.strokeOpacity = "0.47";
            }
        });
}
// focus(blur),input events on search

// search placeholder

const search_form_input_placeholder = "Поиск по названию проекта";
if (document.querySelector(".search-form__field")) {
    document
        .querySelector(".search-form__field")
        .addEventListener("focus", function () {
            this.removeAttribute("placeholder");
        });
    document
        .querySelector(".search-form__field")
        .addEventListener("blur", function () {
            this.placeholder = search_form_input_placeholder;
        });
}

// search placeholder


/// Логика валидации

const dates = [...document.querySelectorAll("[type=date]")]; // инпуты с type=date
const date_names = dates.map((input) => input.name); // имена инпутов с type=date

let messages = {
    fio: "Укажите ваше имя",
    email: "Введите ваш e-mail",
    phone: "Оставьте телефон для доп. связи с вами",
    competencies: "Укажите, что вы хотите выполнять в проекте",
    skill: "Укажите ваши положительные качества, чем занимались ранее",
    course: "Укажите ваш курс",
    training_group: "Укажите вашу учебную группу",
    experience:
        "Поделитесь, принимали ли ранее участие в проектах или в чем-то подобном, делая какую-то конкретную задачу",
    personconfirm:
        "Без согласия на обработку/хранения ваших персональных данных мы не можем принять вашу заявку",
    title: "Введите название проекта",
    goal: "Обозначьте цель проекта",
    idea: "Введите идею проекта",
    requirements: "Задайте требования к участникам",
    expected_result: "Введите ожидаемый результат",
    customer: "Введите заказчика",
    type_id: "Определите тип проекта",
    date_start: "Задайте дату начала проекта",
    date_end: "Задайте дату окончания проекта",
    places: "Укажите сколько<br> человек будет в команде",
    "tags[]": "Укажите хотя бы один тег",
    error_message: "Укажите причину отказа",
    result: "Введите результат проекта",
    username: "Введите логин",
    password: "Введите пароль"
};

const fieldsetsnames = ["course", "personconfirm", "tags[]", "type_id"];

//-------- Функция валидации: ------ //
function validate(form) {
    const fields = [
        ...form.querySelectorAll(
            "[type=text],[type=password], [type=number], textarea, [type=email],[type=date]"
        )
    ].filter((f) => !f.classList.contains("not_required"));
    function sendMessage(field) {
        const require = document.createElement("div");
        if (messages[field.name] !== undefined) {
            require.innerHTML = messages[field.name];
        }
        require.classList.add("error");
        let closestElem = field.closest(".fieldset_wrap")
            ? field.closest(".fieldset_wrap")
            : field.closest("div");
        closestElem.insertBefore(require, closestElem.firstChild);
    }
    form.querySelector("button").addEventListener("click", function (e) {
        for (let message of document.querySelectorAll(".error")) {
            message.remove();
        }
        let correct = true;
        for (let field of fields) {
            if (field.value.trim() == "") {
                sendMessage(field);
                //  field.classList.add("error");
                correct = false;
            }
        }
        //проверка групп радиокнопок (чекбоксов):
        for (let fieldsetname of fieldsetsnames) {
            const variants = [...form.querySelectorAll("input")].filter(
                (input) => input.name == fieldsetname
            );
            if (!variants[0]) {
                continue;
            }
            let select_valid = false;
            for (let radio of variants) {
                if (radio.checked) {
                    select_valid = true;
                    break;
                }
            }
            if (!select_valid) {
                sendMessage(variants[0]);
                correct = false;
            }
        }
        for (let input of form.querySelectorAll("[type=date]")) {
            if (!input.value) {
                input.removeAttribute("name");
            }
        }
        if (!correct) {
            e.preventDefault();
            window.scrollTo(0, 0); // открутил в начало страницы
        }
        if (document.querySelector(".participation-error")) {
            document.querySelector(".participation-error").style.display = correct
                ? "none"
                : "block";
        }
        if (document.querySelector(".form-error")) {
            document.querySelector(".form-error").style.display = correct
                ? "none"
                : "inline-block";
        }
    });
    validate_checkboxes(form);
   // validate_dates(form); // Валидация дат
}
//-----   Конец функции валидации. ---------//
// ------- Функция проверки чекбоксов: -----------//
function validate_checkboxes(form) {
    const limits = {};
    for (let box of form.querySelectorAll("[type=checkbox]")) {
        const class_name = [...box.classList].find((name) =>
            /^c-limit-\d+$/.test(name)
        );
        if (!class_name) {
            continue;
        }
        if (limits[box.name] == undefined) {
            limits[box.name] = +class_name.match(/\d+/g)[0];
        }
    }
    //console.log(limits);
    form.addEventListener("click", function (e) {
        const checkbox = e.target.closest("[type=checkbox]");
        if (!checkbox) {
            return;
        }
        const checkboxes = [...form.querySelectorAll("[type=checkbox]")].filter(
            (ch) => ch.name == checkbox.name
        );
        //!
        //const  checkboxes = [...document.getElementsByName(checkbox.name)];
        const checked = checkboxes.filter((ch) => ch.checked);
        if (checked.length > limits[checkbox.name]) {
            e.preventDefault();
        }
    });
}
for (let form of document.querySelectorAll("form")) {
    validate(form);
}

// Валидация дат
// function validate_dates(form) {
//     function compare_dates(dateString1, dateString2) {
//         const time1 = dateString1.map((digit) => +digit),
//             time2 = dateString2.map((digit) => +digit);
//         // версия с "лесенкой" (тернарный оператор):
//         /*
//         return time2[0] > time1[0]
//           ? false
//           : time2[0] < time1[0]
//           ? true
//           : time2[1] > +time1[1]
//           ? false
//           : time2[1] < time1[1]
//           ? true
//           : time2[2] > time1[2]
//           ? false
//           : true;
//           */
//         // версия с циклом:
//         for (let i = 0; i < time1.length; i++) {
//             if (time1[i] > time2[i]) {
//                 return true;
//             }
//             if (time1[i] < time2[i]) {
//                 return false;
//             }
//         }
//         return true;
//     }
//     const dates = [...form.querySelectorAll("[type=date]")].filter((f) => !f.classList.contains("not_required"));
//     if (!dates.length) {
//         return;
//     }
//     function error_date_message(block,type) {
//         const classText = type === "date_in_past" ? "error_date_in_past" : "error_date_from_to";
//         const text = type === "date_in_past" ? "Вы не можете выбрать дату в прошлом" : "Проверьте даты начала и окончания на логичность";
//         if (!block.closest("div").querySelector(".error_date")) {
//             block.closest("div").insertAdjacentHTML('afterbegin','<div class="error_date ' + classText + '">' + text + '</div>');
//         }
//     }
//     for (let date of dates) {
//         date.oninput = function (e) {
//             if (
//                 !compare_dates(this.value.split("-"), [
//                     new Date().getFullYear(),
//                     new Date().getMonth() + 1,
//                     new Date().getDate()
//                 ])
//             ) {
//                 this.value = "";
//                 error_date_message(this,"date_in_past");
//             }
//             else {
//                 if (this.closest("div").querySelector('.error_date_in_past')) {
//                     this.closest("div").querySelector('.error_date_in_past').remove();
//                     console.log(666);
//                 }
//             }
//         };
//     }
//     const from = form.querySelector("[name=date_start]"),
//         to = form.querySelector("[name=date_end]");
//     if (!(from && to)) {
//         return;
//     }
//     for (let input of [from, to]) {
//         input.addEventListener("input", function (e) {
//             const from_value = from.value,
//                 to_value = to.value;
//             if (
//                 from_value !== "" &&
//                 to_value !== "" &&
//                 !compare_dates(to_value.split("-"), from_value.split("-"))
//             ) {
//                 this.value = "";
//                 // if (!this.closest("div").querySelector('.error_date')) {
//                 //     this.closest("div").insertAdjacentHTML('afterbegin', '<div class="error_date">Дата конца не может быть до даты начала</div>');
//                 // }
//                 error_date_message(this,"date_in_future");
//             } else if (from !== "" &&
//                 to_value !== "" && compare_dates(to_value.split("-"), from_value.split("-"))) {
//                 if (this.closest("div").querySelector('.error_date_from_to')) {
//                     this.closest("div").querySelector('.error_date_from_to').remove();
//                     console.log(777);
//                 }
//             }
//         });
//     }
// }


/// Логика валидации



document.body.addEventListener("input", function (e) {
    const input = e.target.closest("input, textarea");
    if (!input) {
        return;
    }
    input.classList.remove("error");
    const message = input.closest("div").querySelector(".error");
    if (message) {
        message.remove();
    } // при этом у меня каждый ипут обёрнут в div — контейнер.
    if (input.type == "date") {
        input.name = date_names[dates.indexOf(input)];
    }
});


const fieldset_selects = document.querySelectorAll(".fieldset_select");
const null_height = 35,
    padding = 11;
/*Через цикл:*/
for (let fieldset of fieldset_selects) {
    const start_height = parseInt(
        window.getComputedStyle(fieldset).height
    ); /*fieldset.offsetHeight - padding*/
    fieldset.style.height = null_height + "px";
    fieldset.closed = 1; // это флаг, который показывает, открыт сейчас спойлер или закрыт.
    fieldset.animationStarted = false; // сигнализирует о том, что анимация уже запустилась
    fieldset.querySelector("p").onclick = () => {

        if (fieldset.animationStarted) {

            return;
        }
        fieldset.animationStarted = true;
        fieldset.querySelector('.triangle').classList.toggle('triangle_side');
        slideDown(fieldset, null_height, start_height, fieldset.closed);
    };
}

function slideDown(block, minheight, maxheight, flag) {
    let current_height = parseInt(block.style.height);
    if (
        (block.closed == 1 && current_height >= maxheight) ||
        (block.closed == -1 && current_height <= minheight)
    ) {
        block.closed = block.closed * -1; //меняю направление анимации свёртывание <-> развёртывание
        block.animationStarted = false;
        return;
    }

    block.style.height = current_height + 4 * flag + "px";

    setTimeout(() => {
        window.requestAnimationFrame(() => {
            slideDown(block, minheight, maxheight, flag);
        });
    }, 15);
}


// Для выравнивания высот блоков в футере
let blocks = [...document.querySelectorAll(".footer__item")];
let maxHeight = Math.max(...blocks.map((div) => div.offsetHeight));
for (let block of blocks) {
    block.style.height = maxHeight + "px";
}

let rows = document.querySelectorAll('.open-project');
for (let row of rows) {
    blocks = [...row.querySelectorAll(".open-project__card-wrap > div")];
    maxHeight = Math.max(...blocks.map((div) => div.offsetHeight));
    for (let block of blocks) {
        block.style.height = maxHeight + "px";
    }
}


document.body.addEventListener("click", function (event) {
    const mainCross = event.target.closest(".article__adm-delete");
    const insideCross = event.target.closest(".article__control-block .cross");
    const articleStatusError = event.target.closest(".article__status_error");
    const rejectionCross = event.target.closest('.rejection-block .cross');
    let manageWindow = null;
    if (mainCross) {
        mainCross.closest('article').classList.add('article_shading');
        manageWindow = mainCross.parentNode.querySelector(".article__control-block");
        manageWindow.style.display = (window.getComputedStyle(manageWindow).display == 'none') ? 'block' : '';
    }
    if (insideCross) {
        insideCross.closest('article').classList.remove('article_shading');
        manageWindow = insideCross.closest(".article__control-block");
        manageWindow.style.display = (window.getComputedStyle(manageWindow).display == 'none') ? 'block' : '';
    }
    if (articleStatusError) {
        if (articleStatusError.closest('article')) {
            articleStatusError.closest('article').classList.add('article_error-shading');
            rejectionWindow = articleStatusError.parentNode.querySelector(".rejection-block");
            rejectionWindow.style.display = (window.getComputedStyle(rejectionWindow).display == 'none') ? 'block' : '';
        }
        if (articleStatusError.closest('.post-body')) {
            rejectionWindow = articleStatusError.parentNode.querySelector(".rejection-block");
            rejectionWindow.style.display = (window.getComputedStyle(rejectionWindow).display == 'none') ? 'block' : '';
        }
    }
    if (rejectionCross) {
        rejectionCross.closest('article,.post-body').classList.remove('article_error-shading');
        rejectionWindow = rejectionCross.closest(".rejection-block");
        rejectionWindow.style.display = (window.getComputedStyle(rejectionWindow).display == 'none') ? 'block' : '';
    }
});

// code результата


document.body.addEventListener('mouseover',function (ev) {
    const result = ev.target.closest(".blocked");
    if (!result) {
        return;
    }

    if (parseInt(window.getComputedStyle(result).height) <= 30) {
        result.style.borderRadius = "0 0 15px 15px";
        result.style.height = "30px";
        result.style.opacity = "100%";
    }
});

document.body.addEventListener('mouseout',function (ev) {
    const result = ev.target.closest(".blocked");
    if (!result) {
        return;
    }
    if (parseInt(window.getComputedStyle(result).height) <= 30) {
        result.style.borderRadius = "0";
        result.style.height = "15px";
        result.style.opacity = "80%";
    }
});

// 123123


document.body.addEventListener("click", function (ev) {
    const title = ev.target.closest(".article__result");

    if (!title) {return}
    const article = title.closest("article,.post-body");
        if (article.classList.contains('article_close')) {
            article.classList.remove('article_close');
            article.classList.add('article_pseudo_open');
            article.style.filter = "constrast(1) sepia(0)";
            article.style.webkitFilter = "contrast(1) sepia(0)";
            article.style.transition = ".5s";
        } else {
            article.classList.add('article_close');
            article.classList.remove('article_pseudo_open');
            article.removeAttribute('style');
        }
    const resultHeight = 15; // минимальная высота
    const result = title.closest(".article__result");
    result.classList.toggle('article__result_visible');
    animation(
        title.closest(".article__result"),
        parseInt(window.getComputedStyle(title.closest("article,.post-body")).height),
      //  title.closest("article,.post-body").offsetHeight,
        resultHeight,
        0.3
    );

});
function animation(block, maxheight, resultHeight, speed) {
    let s = speed*maxHeight/100;
    block.closed = block.closed ? block.closed * -1 : 1;
    const start = performance.now();
    block.classList.remove('blocked');
    requestAnimationFrame(function animate(time) {
        if (block.closed == 1 && parseInt(window.getComputedStyle(block).height) + 1 < maxheight ||
            block.closed == -1 && parseInt(window.getComputedStyle(block).height) - 1 > resultHeight) {
            block.style.height = block.closed == 1 ? Math.min(maxheight, resultHeight+(time-start)*s) + "px" : Math.max(resultHeight, maxheight-(time-start)*s) + "px";
            requestAnimationFrame(animate);
        } if(parseInt(window.getComputedStyle(block).height) + 1  == maxheight) {
            block.style.borderRadius = 0;

        } if(parseInt(window.getComputedStyle(block).height) - 1 == resultHeight) {
            block.classList.add('blocked');
        }
    });
}

if (document.querySelector('#rejectLink')) {
    document.querySelector('#rejectLink').onclick = function(e) {
        e.preventDefault();
        let approvalForm = document.querySelector('.approval-form');
        approvalForm.style.display = (window.getComputedStyle(approvalForm).display == 'none') ? 'block' : '';
        approvalForm.style.top = getCoords(document.querySelector('#rejectLink')).top + -415 + "px";
    }
}


const showHref = "/admin/projects/show/",
    deleteHref = "/admin/projects/delete/";
for (let i = 0; i < 2; i++) {
    const id = ["project_show", "project_delete"][i],
        href = [showHref, deleteHref][i];
    const input = document.getElementById(id);
    if (input) {
        input.addEventListener("input", function () {
            if (!this.value.trim() == "") {
                this.closest("div").querySelector("a").href = href + this.value;
            } else {
                this.closest("div").querySelector("a").removeAttribute("href");
            }
        });
    }
}

// Высчитываем высоту footer и делаем соответствующий отступ от main:
function footer(){
    let
        main = document.querySelector('.main-content-admin,.main-content'),
        footer = document.querySelector('.footer-admin,.footer');
    if (main != null && footer != null) {
        footerHeight = footer.clientHeight;
        main.style.paddingBottom = (footerHeight) + 'px';
    //    footer.style.marginTop = -(footerHeight) + 'px'
    }
}
window.addEventListener('load',footer);
window.addEventListener('resize',footer);

let counter_parse = 0;

// Подсветка синтаксиса
const fields = [...document.querySelectorAll("form div input[type=text], form div textarea")].filter(field =>[...field.classList].some(className =>/limit/.test(className)));
function parse(str){
    return str.replace(/\</g, "&lt;").replace(/\n$/g, "\n&#8203;");//.replace(/ /g, " ");
}
fields.forEach(field=>{
    const highlight = document.createElement("div");
    highlight.classList.add("highlight");
    field.parentNode.prepend(highlight);
    field.style.backgroundColor="transparent";
    field.style.color="#222";
    //дополнительные стили
    field.closest("div").style.position = "relative";
    field.style.position = "relative";
    field.style.zIndex = "2";
    highlight.style.height = window.getComputedStyle(field).height;
    let maxLength;

    for(let className of [...field.classList]){
        if(/limit/.test(className)){
            maxLength = +className.match(/\d+/)[0];
            break
        }
    }
   // console.log(field.value);
    const sliceEnd = /\n/.test(field.value) ? Math.min(field.value.match(/\n/).index,maxLength)
        : maxLength;

    highlight.innerHTML = "<span class='limit'>"+parse(field.value.slice(0, sliceEnd))+"</span>"+parse(field.value.slice(sliceEnd));
    if ((field.offsetWidth - field.clientWidth) > 10) {
        highlight.style.width = (field.offsetWidth - (field.offsetWidth - field.clientWidth) +1) + "px";
    }
    //highlight.style.width = (textarea.offsetWidth - (textarea.offsetWidth - textarea.clientWidth) +1) + "px";

    //Изменение размера блока с подсветкой
    if (field.tagName == "TEXTAREA") {
        let width = field.clientWidth, height = field.clientHeight;
        field.addEventListener("mouseup", function(){
            if(field.clientWidth != width || field.clientHeight != height){
            //    highlight.style.width = field.clientWidth + 3 + "px";
              //  highlight.style.width = window.getComputedStyle(field).width;
                highlight.style.height = field.clientHeight + 2 + "px";
               // console.log('resized');
                //console.log((field.offsetWidth - field.clientWidth));
                if ((field.offsetWidth - field.clientWidth) > 10) {
                    highlight.style.width = (field.offsetWidth - (field.offsetWidth - field.clientWidth) +1) + "px";
                }
                else {
                    highlight.style.width = window.getComputedStyle(field).width;
                }
            }
            width = field.clientWidth;
            height = field.clientHeight;
        });
    }
    //Изменение размера блока с подсветкой
})
document.body.addEventListener("input", e=>{
    const input = e.target.closest("input[type=text], textarea");
    if(!input){return}
    // вариант 1 :
    //if(!fields.includes(input)){return}
    //const className = [...input.classList].find(name => /limit/.test(name)),
    // maxLength = +className.match(/\d+/)[0];
    //вариант 2 :
    let maxLength;

    for(let className of [...input.classList]){
        if(/limit/.test(className)){
            maxLength = +className.match(/\d+/)[0];
            break
        }
    }
    if(maxLength == undefined){return}
    //console.log(maxLength);
    const highlight = input.parentNode.querySelector(".highlight");
    highlight.innerHTML = parse(input.value);
    const value = highlight.textContent;
  //  highlight.innerHTML = "<span class='limit'>"+parse(value.slice(0, maxLength))+"</span>"+parse(value.slice(maxLength));


    const sliceEnd = /\n/.test(highlight.textContent) ? Math.min(highlight.textContent.match(/\n/).index,maxLength)
        : maxLength;

   // console.log(value.slice(sliceEnd));
    highlight.innerHTML = "<span class='limit'>"+value.slice(0, sliceEnd)+"</span>"+value.slice(sliceEnd);
    // console.log(input.offsetWidth - input.clientWidth);
    highlight.style.width = (input.offsetWidth - (input.offsetWidth - input.clientWidth) +1) + "px";
    //highlight.innerHTML = parse(value.slice(0, maxLength))+"<span class='overlimit'>"+parse(value.slice(maxLength))+"</span>"
})

// При скролле подсветка
for (let textarea of fields) {
    textarea.addEventListener("scroll", e => {
        const highlight = textarea.parentNode.querySelector(".highlight");
        highlight.style.width = (textarea.offsetWidth - (textarea.offsetWidth - textarea.clientWidth) +1) + "px";
        highlight.scrollTop = textarea.scrollTop;
       // console.log((textarea.offsetWidth - textarea.clientWidth) + "scroll event");
    })
}
// При скролле подсветка


// Смена активного элемента при наведении в ЛК администратора
const active_link = document.querySelector(".nav-admin__link_active");
for (let link of document.querySelectorAll(
    ".nav-admin__link"
)) {
    link.addEventListener("mouseover", function () {
        document
            .querySelector(".nav-admin__link_active")
            .classList.remove("nav-admin__link_active");
        link.classList.add("nav-admin__link_active");
    });
    link.addEventListener("mouseout", function () {
        link.classList.remove("nav-admin__link_active");
        active_link.classList.add("nav-admin__link_active");
    });
}
// Смена активного элемента при наведении в ЛК администратора

// Логика closeable

for(let block of document.getElementsByClassName("closeable")){
    block.style.height = block.offsetHeight+"px";
    block.style.marginBottom = window.getComputedStyle(block).marginBottom;
}
document.body.addEventListener("click", (e) => {
    const cross = e.target.closest(".cross"),
        closeable = e.target.closest(".closeable");
    if (!(cross && closeable)) {
        return;
    }
    closeable.style.height = "0px";
    closeable.style.marginBottom = "0";

    closeable.querySelector("span").style.marginTop = "-20px";
    //
    setTimeout(() => {
        closeable.remove();
    }, 2000);
});

if(document.getElementById('title_parent') && document.getElementById('title')) {
    document.getElementById('title').oninput = function() {
        const parent = document.getElementsByClassName('edit-project-title')[0];
        parent.innerHTML = this.value ? truncate(this.value,24,'...') : "&nbsp;";
       // truncate(this.value);
    }
}


function truncate(str,maxWordLength,endLetters) {
    if ("string" !== typeof str) {
        return '';
    }
    const words = str.split(/\s+/g);
    const completedWords = [];
    for (let word of words) {
        if (word.length > maxWordLength)
            completedWords.push(word.slice(0,maxWordLength+1) + endLetters);
        else
            completedWords.push(word);
    }
    return completedWords.join(' ').replace(/\</g, "&lt;");
}

const footer_hover = document.querySelector(".footer");
// let arrow = null;
if (footer_hover) {
    //arrow = footer_hover.querySelector(".arrow");
    footer_hover.classList.add('footer_not_hover');
    footer_hover.onmouseover = () => {
        footer_hover.classList.add("footer_hover");
        footer_hover.classList.remove("footer_not_hover");
    };
    footer_hover.onmouseleave = () => {
        footer_hover.classList.replace("footer_hover", "footer_not_hover");
    };
}
// if (arrow) {
//     arrow.onclick = () => {
//         footer_hover.classList.replace("footer_hover", "footer_not_hover");
//     };
// }


function readCookie(key) {
    const cookies = document.cookie.split(";").map(line => line.split("=")).reduce((obj, record) => {
        if (obj[record[0]] === undefined) {
            obj[record[0]] = record[1]
        }
        return obj;
    }, {});
  //  console.log("cookies: " + JSON.stringify(cookies));
    return cookies[key];
}

function setCookie(key, value, expire) {
    document.cookie = `${key}=${value}; max-age=${expire}`;
}

function deleteCookie(key) {
    setCookie(key, "", 0)
}

// НАВЕРХУ ФУНКЦИИ ДЛЯ РАБОТЫ С COOKIE

const article_first = document.querySelector('.article_close');

document.body.onload = function() {
    if (!readCookie("offDesign_tooltip")) { // если нету куки о всплывающей подсказке
        if (article_first) {
            article_first.insertAdjacentHTML("beforeend", '<div class=\"article_tooltip-close\"><div class=\"cross\"></div>Нажмите, чтобы<br> раскрыть</div>');
            const article_tooltip_close = document.querySelector('.article_tooltip-close');
            article_tooltip_close.style.width = article_tooltip_close.offsetWidth + 10 + "px";
            const wrapper = document.createElement('div');
            article_first.appendChild(wrapper);
            wrapper.appendChild(document.querySelector('.article_tooltip-close'));
            wrapper.id = 'tooltip_wrapper';
            wrapper.style.position = 'absolute';
            wrapper.style.top = window.getComputedStyle(article_tooltip_close).top;
            wrapper.style.left = window.getComputedStyle(article_tooltip_close).left;
            article_tooltip_close.style.position = 'relative';
            article_tooltip_close.style.top = 2 + "px";
            article_tooltip_close.style.left = 0;
            console.log(wrapper.offsetWidth + "--> offsetWidth");
            console.log(window.getComputedStyle(wrapper).width);
            console.log(wrapper.offsetHeight + "--> offsetHeight");
            console.log(wrapper.offsetWidth + 18);
            console.log(wrapper.offsetHeight + 6);
            wrapper.style.width = wrapper.offsetWidth + 18 + "px";
            wrapper.style.height = wrapper.offsetHeight + 6 + "px";
        }
    }
}

document.body.addEventListener('click', function(e) {
    const cross = e.target.closest('.article_tooltip-close .cross');

    if (!e.target.closest('.article__result') && !cross) {
        return;
    }
    const article_tooltip_close = document.querySelector('.article_tooltip-close');

    article_tooltip_close.style.height = article_tooltip_close.offsetHeight;
    setCookie("offDesign_tooltip", true,60*60*2);
    document.getElementById('tooltip_wrapper').style.height = 0;
});


// Реализация функционала cookie_tooltip_close
