const express = require('express')
const route = express.Router()

//controller
const taxController = require('./../controller/tax')

//get
route.get('/tax',taxController.gettax)

//post
route.post('/submit-tax',taxController.posttax)

module.exports= route