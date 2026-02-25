// 1.Class vs Functional Component:
// WelcomeFunc.jsx:
import React from 'react'
function WelcomeFuncTask2 (props) {
  return <h2>Hello,{props.name}</h2>
}
export default WelcomeFuncTask2
// App.jsx:
<WelcomeFuncTask2 name="Raksha"/>

// (WelcomeClass.jsx:
import React,{ Component } from "react";
class WelcomeClassTask2 extends Component{
    render(){
        return <h2>Hello,{this.props.name}</h2>
    }
}
export default WelcomeClassTask2
// App.jsx:
<WelcomeClassTask2 name="Abc"/>

// 2.Props With Destructuring:
// Student.jsx:
import React from "react";
function StudentTask2({name,marks}){
    return(
        <>
        <h2>Name:{name}</h2>
        <h3>Marks:{marks}</h3>
        <h1>
            {marks>40?"Pass":"Fail"}
            </h1>
        </>
    )
}
export default StudentTask2
// App.jsx:
<StudentTask2 name="XYZ" marks={50}/>

// 3.TASK3:Parent->Child Props Rendering:
// Product.jsx:
function ProductTask2({name,price}){
    return(
        <>
        <h2>Product Name:{name}</h2>
        <h3>Price:{price}</h3>
        <h1>
            {price>30000?"Premium Product":"Budget Product"}
        </h1>
        </>
    )
}
export default ProductTask2;
// App.jsx:
<ProductTask2 name="Laptop" price={50000}/>
<ProductTask2 name="Mobile" price={20000}/>

