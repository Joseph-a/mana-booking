import React from 'react';
import Fields from '../fields';

const Tabs = (props) => {
    const { tabInfo, savedSetting, generalInfo } = props;
    return (
        <div className="tab-content-container">
            {
                tabInfo.map((item, index) => <Fields generalInfo={generalInfo} info={item} key={index} savedInfo={savedSetting} {...props} />)
            }
        </div>
    )
}

export default Tabs
