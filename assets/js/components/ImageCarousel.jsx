import React from 'react';
//import { Carousel } from 'react-responsive-carousel';
import Carousel from 'react-bootstrap/Carousel';
import Image from 'react-bootstrap/Image';
//import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
//import { faChevronLeft, faChevronRight } from '@fortawesome/free-solid-svg-icons';

export default function ImageCarousel(props) {
  const { imageList } = props

  return (
    <Carousel prevLabel nextLabel indicators={null} >
    
      {imageList.map(image => (<Carousel.Item key={image.id}>
        <Image src={`/assets/uploadscars/${image.name}`} thumbnail />
      </Carousel.Item>))}

    </Carousel>
  )
}