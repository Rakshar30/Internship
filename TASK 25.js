// 1.Styled Profile Card(All 3 styling Methods):
// CODE:Task3.jsx:
import React from 'react'
import './App.css';
import styles from "./App.module.css"
    function Task3({name,role,company,className}){
    function handleClick(){
        alert("Profile Viewed")
    }
  return (
        <div className={className}>
            <h2 style={{color:"violet"}}>Name:{name}</h2>
            <p>Role:{role}</p>
            <p>Company:{company}</p>
        <button className={styles.btn} onClick={handleClick}>View Profile</button>
        </div>
  )}
export default Task3
// CODE:App.jsx:
<Task3  className="card" name="Rak" role="Full Stack Developer" company="Kakunje"/>
CODE:(App.css):
.card{
  border: 2px solid black;
  padding: 10px;
}
// CODE:App.module.css:
.btn{
    background-color: aqua;
    border-radius: 6px;
}
.btn:hover{
    background-color: brown;
}

// 2.Live Input Display(onChange):
// CODE:Task3OnChange.jsx:
import React, { useState } from 'react'
const Task3OnChange = () => {
  const [name,setName]=useState("");
    return (
      <div>
          <input type="text" placeholder='Enter Your Name' onChange={(e)=>setName(e.target.value)} />
          <h2 style={{color:"green"}}>Hello,{name}</h2>
          </div>
    )
  }
export default Task3OnChange
// CODE:App.jsx:
<Task3OnChange/>

// 3.Simple Login Form(onSubmit):
// CODE:Task3OnSubmit.jsx:
import React, { useState } from 'react'
import './App.css'
const Task3OnSubmit = ({className}) => {
     const [formData,setFormData]=useState({
            email:"",
            password:""
        });
        const handleChange=(e)=>{
            setFormData({
                ...formData,
                [e.target.name]:e.target.value
            })
        }
          const handleSubmit=(e)=>{
        e.preventDefault();
        alert("Login Successful")
}
      return (
        <div className={className}>
            <form onSubmit={handleSubmit}>
            <input type="email" name='email' onChange={handleChange}/>
            <input type="password" name='password' onChange={handleChange}/>
            <button type="submit">submit</button>
            </form>
            </div>
      )
    }
export default Task3OnSubmit
// CODE:App.jsx:
<Task3OnSubmit className="form"/>
// CODE:App.css:
.form{
  width: 280px;
  padding: 20px;
  border: 2px solid black;
  display: flex;
  flex-direction: column;
}
.form button{
  padding: 10px;
  background-color: darkorange;
}

// 4.Feedback Form With Message:
CODE:(Task3Feedback.jsx):
import React, { useState } from 'react'
import styles from './App.module.css';
const Task3Feedback = () => {
    const [name,setName]=useState("");
    const [feedback,setFeedback]=useState("");
    const [submitted, setSubmitted] = useState(false);
     const handleSubmit=(e)=>{
        e.preventDefault();
        setSubmitted(true);
     };  
        return (
          <div>
             <form onSubmit={handleSubmit}>
              <input 
                type="text" 
                placeholder='Enter Your Name' 
                onChange={(e)=>setName(e.target.value)} 
             />
              <textarea 
                placeholder="Feedback" 
                rows="6" 
                cols="6" 
                onChange={(e)=>setFeedback(e.target.value)}>
               </textarea>
               <button className={styles.btnn} type="submit">submit</button>
            </form>
                {submitted && (
                <h2>Thank you {name} for your feedback!</h2>
                )}
              </div>
        );
      };
export default Task3Feedback
// CODE:App.jsx:
<Task3Feedback/>
// CODE:App.module.css:
.btnn {
  background-color: purple;
  color: white;
  padding: 10px 15px;
  border-radius: 6px;
  font-weight: bold;
}
.btnn:hover {
  background-color: rgb(252, 47, 24);
}
