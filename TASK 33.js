// TASK1: Create a basic HTTP Server:
const http=require("http");
const server=http.createServer((req,res)=>{
    res.write("Welcome to the node js");
    res.end();
})
server.listen(3000,()=>{
    console.log("server running");
});

// TASK2: Perform all file system operations(fs module):
// 1) Create File:
const fs=require("fs");
fs.writeFileSync("data.txt","helloo world");

// 2) Read File:
const data=fs.readFileSync("data.txt","utf-8");
console.log(data);

// 3) Update File:
fs.appendFileSync("data.txt","\n this is updated file");

// 4) Delete File:
fs.unlinkSync("data.txt");

// 5) Rename File:
fs.renameSync("data.txt","new_file.txt");

// 6) Create Folder:
fs.mkdirSync("new_folder");
