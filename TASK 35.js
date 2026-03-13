// 1) Find the Output:
console.log("1");
setTimeout(() => {
    console.log("2");
}, 1000);
setTimeout(() => {
    console.log("3");
}, 0);
console.log("4");

// 2) Create basic Express Server:
import express from "express";
const app=express();
app.get("/",(req,res)=>{
    res.send("Welcome to Express Server");
});
app.listen(3000);

// 3) POST API (Test in Postman):
import express from "express";
const app=express();
app.use(express.json());
app.post("/login",(req,res)=>{
    const {username,password}=req.body;
    if(username==="admin" && password==="1234"){
    console.log(req.body);
    res.send("Login Successful");
    }else{
         console.log(req.body);
        res.send("Invalid Credentials");
    }
});
app.listen(3000);
{"username":"admin","password":"1234"}
