import React from 'react';
import Fields from '../fields';

const Tabs = (props) => {
    const { tabInfo, savedSetting, generalInfo } = props;
    return (
        <div className="tab-content-container">
            {
                tabInfo.map((item, index) => <Fields generalInfo={generalInfo} info={item} key={index} savedInfo={savedSetting} onFieldChanged={(fieldIndex, val) => props.onFieldChanged(fieldIndex, val)} />)
            }
        </div>
    )
}

export default Tabs
