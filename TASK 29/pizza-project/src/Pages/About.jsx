import React from 'react';
import MultiplePizzas from "../assets/multiplePizzas.jpeg";
import "../styles/About.css"

function About() {
  return (
    <div className='about'>
        <div 
        className='aboutTop'
        style={{backgroundImage:`url(${MultiplePizzas})`}}>
        </div>
        <div className='aboutBottom'>
            <h1>ABOUT US</h1>
            <p>Kakunje Pizza is a place where great taste meets fresh ingredients. We are passionate about serving delicious, freshly baked pizzas made with high-quality ingredients and authentic recipes. Our goal is to create a warm and welcoming space where friends and families can enjoy tasty food and create memorable moments together. At Kakunje Pizza, every slice is prepared with care to give you the perfect balance of flavor, freshness, and satisfaction.</p>
        </div>

    </div>
  )
}

export default About