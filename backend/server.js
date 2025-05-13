const express = require('express');
const mongoose = require('mongoose');
const morgan = require('morgan');
const jwt = require('jsonwebtoken');
const cors = require('cors');
const user = require('./models/user.model');

const app = express();
const JWT_SECRET = 'your_jwt_secret_key';

// Connect to MongoDB
const dburi = "mongodb+srv://syahmiswork:Syahmi123x@fyp.mward.mongodb.net/?retryWrites=true&w=majority&appName=FYP";
mongoose.connect(dburi, { useNewUrlParser: true, useUnifiedTopology: true })
  .then(() => console.log(' Connected to MongoDB'))
  .catch(err => console.error(' MongoDB connection error:', err));

// Middleware
app.use(morgan('dev'));
app.use(express.json());
app.use(cors()); // Enable CORS for all routes

// Root endpoint
app.get('/', (req, res) => {
  res.json({ message: "Welcome to the API!" });
});

// API Routes
const router = express.Router();

// Test endpoint
router.get('/data', (req, res) => {
  res.json({ message: "Hello from the backend!" });
});

/**
 * @desc Register user (called by Laravel)
 * @route POST /api/auth/register
 */
router.post('/auth/register', async (req, res) => {
  const { name, email, password, role } = req.body;

  try {
    const existingUser = await user.findOne({ email });

    if (existingUser) {
      return res.status(400).json({ message: 'User already exists.' });
    }

    const newUser = new user({
      name,
      email,
      password,
      confirmpassword: password,
      role,
    });

    await newUser.save();

    // Generate a token
    const token = jwt.sign({ id: newUser._id, email: newUser.email }, JWT_SECRET, { expiresIn: '1d' });

    res.status(201).json({
      message: 'User registered successfully',
      user: {
        name: newUser.name,
        email: newUser.email,
        role: newUser.role,
      },
      token: token,
    });
  } catch (err) {
    console.error('❌ Registration error:', err);
    res.status(500).json({ message: 'Server error during registration.' });
  }
});

/**
 * @desc Login user (called by Laravel)
 * @route POST /api/auth/login
 */
router.post('/auth/login', async (req, res) => {
  const { email, password } = req.body;

  try {
    const existingUser = await user.findOne({ email });

    if (!existingUser || existingUser.password !== password) {
      return res.status(400).json({ message: 'Invalid email or password.' });
    }

    // Generate token
    const token = jwt.sign({ id: existingUser._id, email: existingUser.email }, JWT_SECRET, { expiresIn: '1d' });

    res.status(200).json({
      message: 'Login successful',
      user: {
        name: existingUser.name,
        email: existingUser.email,
        role: existingUser.role,
      },
      token: token,
    });
  } catch (err) {
    console.error('❌ Login error:', err);
    res.status(500).json({ message: 'Server error during login.' });
  }
});

// Mount the router
app.use('/api', router);

// Start server
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`🚀 Server is running on http://localhost:${PORT}`);
});
