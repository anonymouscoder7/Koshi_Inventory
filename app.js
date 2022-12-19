const express = require('express')
const path = require('path')
const app = express()
const port = 3000
app.set('view engine','ejs')
app.set('views','view')


//Setting static folder
app.use(express.static(path.join(__dirname, "public")));

const indexRoute = require('./route/index')

app.use(indexRoute)

app.listen(port, () => {
  console.log(`Example app listening on port ${port}`)
})