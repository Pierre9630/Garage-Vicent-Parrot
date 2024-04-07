import React from 'react';
import Carousel from 'react-bootstrap/Carousel';
import Image from 'react-bootstrap/Image';


export default function ImageCarousel(props) {
  const { imageList } = props

  return (
    <Carousel prevLabel nextLabel indicators={null} >
    
      {imageList.map(image => (<Carousel.Item key={image.id}>
        <Image src={`/assets/uploads/${image.name}`} thumbnail />
      </Carousel.Item>))}

    </Carousel>
  )
}