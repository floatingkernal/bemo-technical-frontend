# BeMo developer functional assessment submission

## Quick Links
[Live Demo](http://salmansharif.me/bemo-technical-frontend/)

[Front End Code](https://github.com/floatingkernal/bemo-technical-frontend)

[Back End Code](https://github.com/floatingkernal/bemo-technical-frontend/tree/backend)

## Frontend 
- I used Vue.js to develop a front end interface according to the specification provided in the handout
- I also used Vuex to keep track of the state my application is in
- Features I created are: 
    - ability to create new column by clicking the large red + button
    - ability to delete column by clicking the trash button at the top right of the column
    - ability to add a new card in a column by clicking the green + button at the end of the columns
    - ability to edit and save both column title and card title and description 
    - ability to move cards around by clicking the directional arrows. card move up and down for each column. card also moves left and right but get appended to the end of the column 
- Some bugs I was not able to address right away are:
    - clicking save after changing the title for both card and column does not update the main view automatically. The problem lies somewhere when using the store and the data is updated there. Clicking save does save the changes in the backend and refreshing the page or moving cards around will show the correct information. 
    - I was not able to implement the function for dumping the database. I was having problems with mysqldump not working on my machine or the server I am using. The button for downloading the data base exists but currently does not download the file as needed.
- As for styling, I used scss with the bem standard wiht the best of my ability. I would prefer using a third party library such as bootstrap or vuetify to make it look more applealing but I was not sure if that went against the assessments guidlines. 
- front end code is available at: https://github.com/floatingkernal/bemo-technical-frontend
- The front end was deployed using github pages. The live demo is available at http://salmansharif.me/bemo-technical-frontend/ 

## Backend
- I created a rest api using laravel in the backend. 
- I have deployed the backend using heroku
- Brief overview of the architecture:
    - each column has a head card that points towards the first card in the list
    - each card had a pointer to the next and previous cards
    - to get the list of cards in a column, start with the head card and while there is a next card avaialble, get that card and append it to the list and repeat. 
    - reason for this approach was because we needed to be able to chage the location of the card and linked list works best to change the order of the card in an efficient manner.
- backend code is available at: https://github.com/floatingkernal/bemo-technical-frontend/tree/backend
- Below is the documentation for the rest api I created
- Testing was conducted maually. for instance, manually check the front end was sending the data correctly in the backend and the backend was producing exptect actions as a result. I did not have the time to write automated tests for this application at the moment. In the future I would add many test cases.

# Backend REST api documentation:
### Get Board
- description: gets all the columns along with all cards attached to each column
- request: `GET /api/getBoard`
- response: 200 
    - content-type: `application/json`
    - body: list of Column objects
        - id: (number) the id of the room
        - title: (string) the title of the column
        - head_card: (number) id of the first card in the column
        - timestamp: (datetime) timestamp of the column
        - cards: list of Cards each with
            - id: (number) the id of the card
            - title: (string) the title of the card
            - desc: (string) the description of the card
            - next: (number) id of the next card in the list
            - prev: (number) id of the previous card in the list
            - timestamp: (datetime) timestamp of the card
 ``` 
 $ curl -X GET
         https://bemo-technical-backend.herokuapp.com/api/getBoard
 ``` 
### Update Column Title
- description: updates the column name in the backend
- request: `POST /api/updateColumnTitle`
    - content-type: `application/json`
    - body: object
        - id: (number) id of the column
        - title: (string) the title of the column
- response: 200 
    - content-type: `application/json`
    - body: Column object
        - id: (number) the id of the column
        - title: (string) the title of the column
        - head_card: (int) id of the first card in the column
        - timestamp: (datetime) timestamp of the column
 ``` 
$ curl -X POST 
       -H "Content-Type: `application/json`" 
       -d '{
            "id": 1,
            "title": "some random title"
         }'
         https://bemo-technical-backend.herokuapp.com/api/updateColumnTitle
 ``` 
### Add Column
- description: Adds new column in the backend
- request: `POST /api/addColumn`
    - content-type: `application/json`
    - body: object
        - title: (string) the title of the column
- response: 201 object suscessfull created 
    - content-type: `application/json`
    - body: Column object
        - id: (int) the id of the room
        - title: (string) the title of the column
        - head_card: null
        - timestamp: (datetime) timestamp of the column
 ``` 
$ curl -X POST 
       -H "Content-Type: `application/json`" 
       -d '{
            "title": "some random title"
         }'
         https://bemo-technical-backend.herokuapp.com/api/addColumn
 ``` 
 
### Delete Column
- description: Deletes the column and all the cards in the column 
- request: `DELETE /api/delColumn/{id}`
    - id: (number) id of the column thats being deleted
- response: 204 object suscessfull deleted 

 ``` 
$ curl -X DELETE 
         https://bemo-technical-backend.herokuapp.com/api/delColumn/1/
 ``` 
### Add Card
- description: Adds new card in the column in the backend
- request: `POST /api/addCard`
    - content-type: `application/json`
    - body: object
        - column_id: (number) column id card belongs to
        - title: (string) the title of the card
        - desc: (string) the description of the card
- response: 201 object suscessfull created 
    - content-type: `application/json`
    - body: card object
        - id: (int) the id of the card
        - title: (string) the title of the card
        - desc: (string) the description of the card
        - next: null
        - prev: null
        - timestamp: (datetime) timestamp of the card
 ``` 
$ curl -X POST 
       -H "Content-Type: `application/json`" 
       -d '{
            "column_id": 1,
            "title": "some random title",
            "desc": "some random description"
         }'
         https://bemo-technical-backend.herokuapp.com/api/addCard
 ``` 
### Update Card Items
- description: Updates cards title and description in the backend
- request: `POST /api/updateCardItem`
    - content-type: `application/json`
    - body: object
        - card_id: (number) id of the card
        - title: (string) the new title of the card
        - desc: (string) the new description of the card
- response: 200 object suscessfull updated 
    - content-type: `application/json`
    - body: card object
        - id: (int) the id of the card
        - title: (string) the title of the card
        - desc: (string) the description of the card
        - next: (number) the id of the next card
        - prev: (number) the id of the previous card
        - timestamp: (datetime) timestamp of the card
 ``` 
$ curl -X POST 
       -H "Content-Type: `application/json`" 
       -d '{
            "card_id": 1,
            "title": "some random title",
            "desc": "some random description"
         }'
         https://bemo-technical-backend.herokuapp.com/api/updateCardItem
 ``` 
### Update Card Location
- description: Updates cards location in the backend
- request: `POST /api/updateCardItem`
    - content-type: `application/json`
    - body: object
        - card_id: (number) id of the card
        - column_id: (number) id of the new column card belongs to
        - old_column_id: (number) id of the new column card belongs to
        - direction: (string) must be one of only `UP` `DOWN` `LEFT` or `RIGHT`
- response: 200 object suscessfull updated 
    - content-type: `application/json`
    - body: card object
        - id: (int) the id of the card
        - title: (string) the title of the card
        - desc: (string) the description of the card
        - next: (number) the id of the next card
        - prev: (number) the id of the previous card
        - timestamp: (datetime) timestamp of the card
 ``` 
$ curl -X POST 
       -H "Content-Type: `application/json`" 
       -d '{
            "card_id": 1,
            "column_id": 2
            "old_column_id": 1 
            "direction": "UP" 
         }'
         https://bemo-technical-backend.herokuapp.com/api/updateCardItem
 ``` 
### Export Databae
**This feature is not working at the moment**
- description: exports the database to a file
- request: `GET /api/exportDB`
- response: 500 Feature not available
 ``` 
 $ curl -X GET
         https://bemo-technical-backend.herokuapp.com/api/exportDB
 ``` 
#