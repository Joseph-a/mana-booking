import React from 'react';
import Fields from './fields';

const Tabs = ( props ) => {
	return (
		<div className="tab-content-container">
            {
                props.tabInfo.map((item,index) => <Fields info={item} key={index} onFieldChanged={val => props.onFieldChanged(val, index)}/>)
            }            
        </div>
	)
}

export default Tabs
