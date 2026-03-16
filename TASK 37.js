// 1) Product Schema using MongoDB:
// db.js:
import mongoose from "mongoose";
const connectDB = async () => {
    try {
        await mongoose.connect('mongodb://127.0.0.1:27017/products');
        console.log("MongoDB connected successfully");
    } catch (error) {
        console.error("Database connection failed:", error.message);
        process.exit(1);
    }
};
export default connectDB;

// product.js:
import mongoose from "mongoose";
const productSchema = new mongoose.Schema({
    name: {
        type: String,
        required: true
    },
    price: {
        type: Number,
        required: true,
    },
    category: {
        type: String,
        required: true
    },
    stock: {
        type: Number,
        required: true,
    }
}, { timestamps: true });
const Product = mongoose.model("Product", productSchema);
export default Product;

// productroutes.js:
import express from "express";
import Product from "../models/product.js"; 
const router = express.Router();
router.post("/products", async (req, res) => {
    try {
        const product = new Product(req.body);
        await product.save();
        res.status(201).json(product);
    } catch (error) {
        res.status(500).json({ message: error.message });
    }
});
router.get("/products", async (req, res) => {
    try {
        const products = await Product.find();
        res.json(products);
    } catch (error) {
        res.status(500).json({ message: error.message });
    }
});
export default router;

// server.js:
import express from "express";
import dotenv from "dotenv";
import connectDB from "./config/db.js";
import productRoutes from "./routes/productroutes.js"; 
dotenv.config();
connectDB(); 
const app = express();
app.use(express.json());
app.use("/api", productRoutes);
const PORT = process.env.PORT;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
