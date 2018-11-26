Приклад наявних даних:
departureAirport: BCN
arrivalAirport: VIE
departureDate: 26-11-2018 / 27-11-2018


Реализовать API и интерфейс к нему.
Интерфейс оформить в виде небольшого веб-приложения из одной страницы
(дизайн не важен).
С помощью этого приложения и API можно осуществлять поиск перелётов между
двумя аэропортами на конкретную дату.
Входные данные от пользователя:
**- аэропорт вылета
- аэропорт назначения
- дата перелета**
Результатом поиска является список рейсов на выбранную дату между указанными
аэропортами.
По каждому рейсу известно:
**- перевозчик
- номер рейса
- время вылета (местное время)
- время прилета (местное время)
- длительность перелёта в минутах**
Результаты вывести в порядке времени вылета.
Для поиска реализовать серверную и клиентскую часть API из одного метода:
- **search**
Справочник поддерживаемых перевозчиков и аэропортов - придумать
самостоятельно.
Реализовать базовые сообщения об ошибках:
- неверный запрос
- неверно указан аэропорт
- неверно указана дата вылета
- ничего не найдено
Предусмотреть Basic авторизацию.

Пример запроса search к API в формате JSON:
``{
    "searchQuery": {
        "departureAirport": "KBP",
        "arrivalAirport": "BUD",
        "departureDate": "2018-07-01"
    }
  }``
Пример ответа на запрос search к API в формате JSON:


``{
    "searchQuery": {
        "departureAirport": "IEV",
        "arrivalAirport": "BUD",
        "departureDate": "2018-07-01"
    },
    "searchResults": [
        {
            "transporter": {
                "code": "W6",
                "name": "WizzAir"
            },
            "flightNumber": "W64556",
            "departureAirport": "IEV",
            "arrivalAirport": "BUD",
            "departureDateTime": "2018-07-01 09:30",
            "arrivalDateTime": "2018-07-01 12:10",
            "duration": 100
        },
        {
            "transporter": {
                "code": "PS",
                "name": "UkraineInternational"
            },
            "flightNumber": "PS1234",
            "departureAirport": "IEV",
            "arrivalAirport": "BUD",
            "departureDateTime": "2018-07-01 10:00",
            "arrivalDateTime": "2018-07-01 12:35",
            "duration": 95
        },
        {
            "transporter": {
                "code": "W6",
                "name": "WizzAir"
            },
            "flightNumber": "W64558",
            "departureAirport": "IEV",
            "arrivalAirport": "BUD",
            "departureDateTime": "2018-07-01 18:00",
            "arrivalDateTime": "2018-07-01 20:30",
            "duration": 90
        }
    ]
  }``
