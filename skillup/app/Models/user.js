const mongoose = require('mongoose');
const Schema = mongoose.Schema;

//structure of document
const userSchema = new Schema({
    name:{
        type: String,
        required: true
    },
    email:{
        type: String,
        required: true
    },
    password:{
        type: String,
        required: true
    },
    confirmpassword:{
        type: String,
        required: true
    },
    role:{
        type: String,
        required: true
    },

}, {timestamps:true}); 

const user = mongoose.model('User', userSchema);
module.exports = user;