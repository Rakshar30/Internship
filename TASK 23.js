// React:
// 1.Displaying Student Details Using React:
import React from 'react'
const Task1 = () => {
    var student_name="Abc";
    var course="MCA";
    var year=2026;
  return (
    <>
    <h1>Student Name:<span style={{color:"green"}}>{student_name}</span></h1>
    <h2>Course:{course}</h2>
    <h3>Year:{year}</h3>
    </>
  )
}
export default Task1;

// 2.Performing Multiplication Using React:
import React from 'react'
const Task1 = () => {
    const num1=5;
    const num2=4;
  return (
    <>
    <h2>Multiplication is {num1*num2}</h2>
    </>
  )
}
export default Task1;

// 3.Simple Button With Console Message:
import React from 'react'
function  Task1click(){
    function handleClickk(){
        alert("Form Submitted")
        console.log("Submitted Successfully")
    }
    return <button type="submit" onClick={handleClickk}>Submit</button>
}
export default Task1click

// 4.Styling Paragraph Component
import React from 'react'
const Task1 = () => {
    var Message="Hello World";
  return (
    <>
    <h1 style={{color:"purple",backgroundColor:"lightgray",padding:"10px"}}>{Message}</h1>
    </>
  )
}
export default Task1;
