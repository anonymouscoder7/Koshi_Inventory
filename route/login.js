const express = require('express')
const route = express.Router()
 //comtroller
 const loginController = require('./../controller/login')

 //get
 route.get('/login',loginController.getlogin)
 
 //post
 route.post('/submit-login',loginController.postlogin)

 module.exports = route