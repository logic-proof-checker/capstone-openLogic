<<<<<<< HEAD
# mern-auth

![Final App](https://i.postimg.cc/tybZb8dL/final-MERNAuth.gif)
Minimal full-stack MERN app with authentication using passport and JWTs.

This project uses the following technologies:

- [React](https://reactjs.org) and [React Router](https://reacttraining.com/react-router/) for frontend
- [Express](http://expressjs.com/) and [Node](https://nodejs.org/en/) for the backend
- [MongoDB](https://www.mongodb.com/) for the database
- [Redux](https://redux.js.org/basics/usagewithreact) for state management between React components

## Medium Series

- [Build a Login/Auth App with the MERN Stack — Part 1 (Backend)](https://blog.bitsrc.io/build-a-login-auth-app-with-mern-stack-part-1-c405048e3669)
- [Build a Login/Auth App with the MERN Stack — Part 2 (Frontend & Redux Setup)](https://blog.bitsrc.io/build-a-login-auth-app-with-mern-stack-part-2-frontend-6eac4e38ee82)
- [Build a Login/Auth App with the MERN Stack — Part 3 (Linking Redux with React Components)](https://blog.bitsrc.io/build-a-login-auth-app-with-the-mern-stack-part-3-react-components-88190f8db718)

## Configuration

Make sure to add your own `MONGOURI` from your [mLab](http://mlab.com) database in `config/keys.js`.

```javascript
module.exports = {
  mongoURI: "YOUR_MONGO_URI_HERE",
  secretOrKey: "secret"
};
```

## Quick Start

```javascript
// Install dependencies for server & client
npm install && npm run client-install

// Run client & server with concurrently
npm run dev

// Server runs on http://localhost:5000 and client on http://localhost:3000
```

For deploying to Heroku, please refer to [this](https://www.youtube.com/watch?v=71wSzpLyW9k) helpful video by TraversyMedia.
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
>>>>>>> f658c10153012914ed9b79a865bdb5f8de880844
