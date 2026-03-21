// 1) Food Ordering Backend API:
// CONFIG:
// db.js:
import mongoose from "mongoose";
const connectDB = async () => {
  try {
    await mongoose.connect(process.env.MONGO_URI);
    console.log("MongoDB Connected Successfully");
  } catch (error) {
    console.error("Database Connection Failed:", error);
    process.exit(1);
  }
};
export default connectDB;

// CONTROLLERS:
// i) customerController.js:
import Customer from "../models/Customer.js";
export const createCustomer = async (req, res) => {
  try {
    const newCustomer = await Customer.create(req.body);
    res.status(201).json(newCustomer);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
export const getCustomers = async (req, res) => {
  try {
    const customers = await Customer.find();
    res.json(customers);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
export const getCustomerById = async (req, res) => {
  try {
    const customer = await Customer.findById(req.params.id);
    if (!customer) return res.status(404).json({ message: "Customer not found" });
    res.json(customer);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
export const updateCustomer = async (req, res) => {
  try {
    const updatedCustomer = await Customer.findByIdAndUpdate(
      req.params.id,
      req.body,
      { new: true }
    );
    res.json(updatedCustomer);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
export const deleteCustomer = async (req, res) => {
  try {
    await Customer.findByIdAndDelete(req.params.id);
    res.json({ message: "Customer deleted successfully" });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

// ii) foodController.js:
import Food from "../models/Food.js";
export const createFood = async (req, res) => {
  try {
    const food = await Food.create(req.body);
    res.status(201).json(food);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
export const getFoods = async (req, res) => {
  try {
    const foods = await Food.find();
    res.json(foods);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
export const updateFood = async (req, res) => {
  try {
    const food = await Food.findByIdAndUpdate(req.params.id, req.body, {
      new: true,
    });
    res.json(food);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
export const deleteFood = async (req, res) => {
  try {
    await Food.findByIdAndDelete(req.params.id);
    res.json({ message: "Food item deleted successfully" });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

// iii) orderController.js:
import Order from "../models/Order.js";
import Food from "../models/Food.js";
export const createOrder = async (req, res) => {
  try {
    const { customerId, foodId, quantity } = req.body;
    const food = await Food.findById(foodId);
    if (!food) return res.status(404).json({ message: "Food item not found" });
    const totalPrice = food.price * quantity;

    const newOrder = await Order.create({
      customerId,
      foodId,
      quantity,
      totalPrice,
    });
    res.status(201).json(newOrder);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
export const getOrders = async (req, res) => {
  try {
    const orders = await Order.find().populate("customerId foodId");
    res.json(orders);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
export const getOrderById = async (req, res) => {
  try {
    const order = await Order.findById(req.params.id).populate("customerId foodId");
    if (!order) return res.status(404).json({ message: "Order not found" });
    res.json(order);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
export const updateOrder = async (req, res) => {
  try {
    const updated = await Order.findByIdAndUpdate(
      req.params.id,
      { status: req.body.status },
      { new: true }
    );
    res.json(updated);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
export const deleteOrder = async (req, res) => {
  try {
    await Order.findByIdAndDelete(req.params.id);
    res.json({ message: "Order deleted successfully" });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

// MODELS:
// i) Customer.js:
import mongoose from "mongoose";
const customerSchema = new mongoose.Schema({
  name: { 
    type: String, 
    required: true 
},
  email: { 
    type: String, 
    required: true, 
    unique: true 
},
  phone: { 
    type: String, 
    required: true 
},
  address: { 
    type: String, 
    required: true 
}
});
export default mongoose.model("Customer", customerSchema);

// ii) Food.js:
import mongoose from "mongoose";
const foodSchema = new mongoose.Schema({
  name: { 
    type: String, 
    required: true 
},
  price: { 
    type: Number, 
    required: true 
},
  category: { 
    type: String, 
    required: true 
},
  isAvailable: { 
    type: Boolean, 
    default: true 
}
});
export default mongoose.model("Food", foodSchema);

// iii) Order.js:
import mongoose from "mongoose";
const orderSchema = new mongoose.Schema({
  customerId: { 
    type: mongoose.Schema.Types.ObjectId, 
    ref: "Customer", 
    required: true 
},
  foodId: { 
    type: mongoose.Schema.Types.ObjectId, 
    ref: "Food", 
    required: true 
},
  quantity: { 
    type: Number, 
    required: true 
},
  totalPrice: { 
    type: Number, 
    required: true 
},
  status: {
    type: String,
    enum: ["pending", "preparing", "delivered"],
    default: "pending"
  }
});
export default mongoose.model("Order", orderSchema);

// ROUTES:
// i) customerRoutes.js:
import express from "express";
import {
  createCustomer,
  getCustomers,
  getCustomerById,
  updateCustomer,
  deleteCustomer
} from "../controllers/customerController.js";
const router = express.Router();

router.post("/", createCustomer);
router.get("/", getCustomers);
router.get("/:id", getCustomerById);
router.put("/:id", updateCustomer);
router.delete("/:id", deleteCustomer);
export default router;

// ii) foodRoutes.js:
import express from "express";
import {
  createFood,
  getFoods,
  updateFood,
  deleteFood
} from "../controllers/foodController.js";
const router = express.Router();
router.post("/", createFood);
router.get("/", getFoods);
router.put("/:id", updateFood);
router.delete("/:id", deleteFood);
export default router;

// iii) orderRoutes.js:
import express from "express";
import {
  createOrder,
  getOrders,
  getOrderById,
  updateOrder,
  deleteOrder
} from "../controllers/orderController.js";
const router = express.Router();
router.post("/", createOrder);
router.get("/", getOrders);
router.get("/:id", getOrderById);
router.put("/:id", updateOrder);
router.delete("/:id", deleteOrder);
export default router;

// .env:
PORT=5000
MONGO_URI=mongodb://127.0.0.1:27017/food

// server.js:
import express from "express";
import dotenv from "dotenv";
import connectDB from "./config/db.js";
import customerRoutes from "./routes/customerRoutes.js";
import foodRoutes from "./routes/foodRoutes.js";
import orderRoutes from "./routes/orderRoutes.js";
dotenv.config();
connectDB();
const app = express();
app.use(express.json());
app.use("/api/customers", customerRoutes);
app.use("/api/foods", foodRoutes);
app.use("/api/orders", orderRoutes);
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
