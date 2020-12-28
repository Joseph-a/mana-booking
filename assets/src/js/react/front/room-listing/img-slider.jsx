import React from 'react'
import t from 'prop-types'
import Slider from "react-slick";

const ImgSlider = (props) => {
    const { imgList, title } = props;
    const settings = {
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        cssEase: 'linear'
    };
    return (
        <Slider {...settings}>
            {
                imgList.map(img => {
                    return (
                        <div key={img.id}>
                            <img src={img.code.large} alt={title} />
                        </div>
                    )
                })
            }
        </Slider>
    )
}
ImgSlider.propTypes = {
    imgList: t.array
}

export default ImgSlider
