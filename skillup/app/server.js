const express = require('express');
const mongoose = require('mongoose');
const morgan = require('morgan');
const user = require('./Models/user');


const app = express();

// Connect to MongoDB
const dburi = "mongodb+srv://syahmiswork:Syahmi123x@fyp.mward.mongodb.net/SkillUp?retryWrites=true&w=majority&appName=FYP";
mongoose.connect(dburi, { useNewUrlParser: true, useUnifiedTopology: true })
  .then(() => console.log('Connected to MongoDB'))
  .catch(err => console.error(err));

app.use(morgan('dev'));
app.use(express.json());


app.get('/add-user',(reg,res)=>{
    const User = new user({
        name: 'Syahmi',
        email: 'syahmi@gmail.com',
        password: '123456',
        confirmpassword: '123456',
        role: 'admin',
    })

  User.save()
    .then((result) => {
      res.send(result);
    })
    .catch((err) => {
      console.error(err);
      res.status(500).send("Error saving user.");
    });
});

app.get('/all-users', (req, res) => {
    user.find()
    .then((result) => {
        res.send(result);
    })
    .catch((err) => {
        console.log(err);
    })
})

// Example API Route
app.get('/api/data', (req, res) => {
  res.json({ message: "Hello from the backend!" });
});

// Start the server
app.listen(3000, () => {
  console.log('Server is running on http://localhost:3000');
});