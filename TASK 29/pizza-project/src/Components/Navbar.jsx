import React, { useState } from 'react'
import Logo from "../assets/pizzaLogo.png";
import {Link} from "react-router-dom";
import "../styles/Navbar.css";
import ReorderIcon from '@mui/icons-material/Reorder';
import DarkModeIcon from '@mui/icons-material/DarkMode';
import LightModeIcon from '@mui/icons-material/LightMode';

const Navbar = () => {

  const [openLinks, setOpenLinks] = useState(false);
  const [darkMode, setDarkMode] = useState(true);

  const toggleNavbar = () => {
    setOpenLinks(!openLinks);
  };

  const toggleTheme = () => {
    setDarkMode(!darkMode);
    document.body.classList.toggle("light-mode");
  };

  return (
    <div className='navbar'>
      
      <div className='leftSide' id={openLinks ? "open" : "close"}>
        <img src={Logo} alt="logo"/>

        <div className='hiddenLinks'>
          <Link to="/">Home</Link>
          <Link to="/menu">Menu</Link>
          <Link to="/about">About</Link>
          <Link to="/contact">Contact</Link>  
        </div>
      </div>

      <div className='rightSide'>
        <Link to="/">Home</Link>
        <Link to="/menu">Menu</Link>
        <Link to="/about">About</Link>
        <Link to="/contact">Contact</Link>

        <button className="themeBtn" onClick={toggleTheme}>
          {darkMode ? <LightModeIcon/> : <DarkModeIcon/>}
        </button>

        <button className="menuBtn" onClick={toggleNavbar}>
          <ReorderIcon/>
        </button>

      </div>

    </div>
  )
}

export default Navbar