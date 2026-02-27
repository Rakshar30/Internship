// 1. Simple Counter With Background Change(UseState+Styling):
// CODE: Task4Counter6.jsx:
import React from 'react'
import useTask4Counter from './useTask4Counter';
const Task4Counter6 = () => {
    const {count,increment,decrement}=useTask4Counter(0);
    const bgstyle={
        backgroundColor:count>5?"green":"violet",padding:"30px",textAlign:"center"
    }
  return (
    <div style={bgstyle}>
        <h1>{count}</h1>
        <button onClick={increment}>+</button>
        <button onClick={decrement}>-</button>
    </div>
  )
}
export default Task4Counter6
// CODE: useTask4Counter.jsx:
import React, { useState } from 'react'
const useTask4Counter = (initialValue=0) => {
        const [count,setCount]=useState(initialValue);
        const increment=()=>{
            setCount(prev=>prev+1);
        }
         const decrement=()=>{
            setCount(prev=>prev-1);
        }
            return{count,increment,decrement}
}
export default useTask4Counter
// CODE: App.jsx:
 <Task4Counter6/>
  
// 2. Auto Welcome Message(UseEffect):
// CODE: Task4UseEffect.jsx:
import React, { useEffect } from 'react'
const Task4UseEffect = () => {
    useEffect(()=>{
            alert("Welcome to React Hooks");
            console.log("component mounted");
        },[]);
      return (
        <div>Welcome to React Hooks</div>
      )
    }
export default Task4UseEffect
// CODE:  App.jsx:
 <Task4UseEffect/>
   
// 3. Auto Welcome Message(UseEffect):
// CODE: Task4UseEffect.jsx:
import React, { useState, useRef, useEffect } from 'react';
const Task4Ref = () => {
  const [showInput, setShowInput] = useState(false);
  const inputRef = useRef(0);
  useEffect(() => {
    if (showInput) {
      inputRef.current.focus();
    }
  }, [showInput]);
  return (
    <div>
      <button onClick={() => setShowInput(true)}>Show Message</button>
      {showInput && (
        <div>
          <input
            type="text"
            ref={inputRef}
          />
        </div>
      )}
    </div>
  );
};
export default Task4Ref;
// CODE: App.jsx:
 <Task4Ref/>
