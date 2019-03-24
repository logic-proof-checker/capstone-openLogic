Adding login capabilities


=======
Adding login/signup features 

 # The package contents:

 --- Client: Contains the frontend for the application which is written in react.js and the state of the application is handled by Redux.

 --- Server:All things for the backend written in Node.js, Passport.js and MongoDB.

 1. The database is MongoDB with a mongoose client. The account which is used with Mongo is personal use.
2. The Authenitcation is done using Passport.js 

 The page is a single paged application which allows for users to register using their email addresses.

 How to Run: 

 Both the Client and Server have packages that are installed seperately. Until the time that migrating packages is done by changing the addresses: 

 1. Run **npm install** on the root of the page.
2. Run **npm install** inside the client folder.

 3. Run **npm run client && npm run server** on the terminal OR for production *npm run dev* to run concurrently (Not reccomended for testing purposes?)
