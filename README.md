# makeit

**1. Создать класс с статическим методом выбора раздела по символьному коду с кешированием выборки.**
Через компонент чисто для визуала. Подключение компонента: section-code.php в корне.
Сам компонент: local\components\fumuse\section.code\class.php
Класс getSection();

**2. Написать фильтр для catalog.section, для фильтрации товаров по значению пользовательского свойства типа список и типа справочник.**
Смотреть через catalog-section.php в корне.

**3. Требуется реализовать вывод новостей и голосование за новость на Bitrix Framework.**
**Под новостью должно быть количество голосов и две кнопки “Проголосовать -” и “Проголосовать +”.**
**Проголосовать с одного IP адреса можно один раз за всё время.**
Смотреть через news-with-reps.php в корне.
Шаблон компонента "Новости": local\templates\furniture_pink\components\bitrix\news\.default\
	• добавлен дополнительный параметр шаблона (ид инфоблока с репутациями) в .parameters.php
	• подключение jquery в detail.php
	• пробрасывание ид инфоблока с репутацией с родительского компонента Новости на детальную страницу
Шаблон компонента "Новость детально" (на которой репутация): local\templates\furniture_pink\components\bitrix\news\.default\bitrix\news.detail\.default\
	• script.js: отправка аякса при нажатии на голосование и его отработка, изменение внешнего вида детальной страницы в зависимости от данных вне кеша
	• style.css: внешнее оформление блока голосования
	• component_epilog.php: вытягивание динамичных данных, таких как количество репутации новости и голосовал ли пользователь за новость или нет
	• template.php: сам шаблон и вёрстка блока с репутацией 
Обработка голосования за новость: local\templates\furniture_pink\components\bitrix\news\.default\bitrix\news.detail\.default\ajax\rating.php
Содержимое инфоблоков в формате .csv в папке iblocks-csv\ в корне. 
Для отображения голосования добавлялось пользовательское поле "Рейтинг новости (NEWS_RATING)" в инфоблок Новостей и создавался отдельный инфоблок "Рейтинг новостей" со свойствами "Новость (NEWS_ID)" (привязка к элементу инфблока Новостей) и "Число рейтинга (VOTE_COUNT)" (на какое число изменялся рейтинг 1/-1). Информация по IP записывается в поле "Название" ИБ.
