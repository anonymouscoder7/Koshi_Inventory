exports.gettax=(req,res)=>{
    res.render('tax')
}

//controller

exports.posttax=(req,res)=>{
    let a = parseInt(req.body.amount)
    let b = parseInt(req.body.tax)

    let cal = a*(b/100)
    console.log(cal)

    res.status(200).send({
        data:cal
    })

}