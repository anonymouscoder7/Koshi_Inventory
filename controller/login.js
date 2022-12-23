exports.getlogin= (res,req)=>{
    res.render('login')
}
let usernamne ="sushma"
let password="hello"
exports.postlogin = (req,res)=>{
    console.log(req.body.usernamne)
    console.log(req.body.password)

    if(usernamne== user){
        if(password==pass){
            res.status(200).send({
                data:"sucess login"
            })
        }
    }else{
        res.status(200).send({
            data:"password does not match"
        })
    }
}
