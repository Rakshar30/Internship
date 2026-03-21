// 1) Using Environment Variables:
import http from "http";
import dotenv from "dotenv";

dotenv.config();

const PORT=process.env.PORT;
const APP_NAME=process.env.APP_NAME;
const server=http.createServer((req,res)=>{
    res.write(`App Name:${APP_NAME}`);
    console.log("App Name:",APP_NAME);
    res.end();
})
server.listen(PORT,()=>{
    console.log("Server running on Port:",PORT);
});
// .env:
PORT=5000
APP_NAME=Intern Training App
  
// 2) setTimeout Example:
console.log("Server Starting...")
setTimeout(()=>{
    console.log("Server Started Successfully");
},3000);

// 3) Simple Promise:
const promise=new Promise((resolve,reject)=>{
    let number=11;
    if(number>10){
        resolve("Number is greater than 10");
    }else{
        reject("Number is less than or equal to 10");
    }
});
promise.then((result)=>{
    console.log(result);
})
.catch((error)=>{
    console.log(error);
});
