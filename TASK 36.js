// 1) Create a Product API with CRUD operations:
import express from "express";

const app=express();

app.use(express.json());

let products=[
    {id:1,name:"Laptop",price:50000},
    {id:2,name:"Mobile",price:20000}
];
app.get("/products",(req,res)=>{
    res.json(products);
});

app.post("/products",(req,res)=>{
    const newUser={
        id:products.length+1,
        name:req.body.name
    };
        products.push(newUser);
        res.status(201).json(newUser)
});
app.put("/products/:id",(req,res)=>{
    const id=parseInt(req.params.id);
    const user=products.find(u=>u.id===id);
    if(!user){
        return res.status(404).send("product not found");
    }
    user.name=req.body.name;
    res.json(user);

});

app.delete("/products/:id",(req,res)=>{
    const id=parseInt(req.params.id);

    products=products.filter(u=>u.id !==id);
    res.send("product deleted");
});

app.listen(3000,()=>{
    console.log("server is running");
});
