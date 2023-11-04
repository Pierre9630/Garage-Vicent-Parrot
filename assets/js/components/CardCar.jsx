import React from 'react';
import ReactDOM from 'react-dom';
import images from "core-js/internals/array-iteration";
import * as PropTypes from "prop-types";
//import "react-responsive-carousel/lib/styles/carousel.min.css"; // requires a loader
import { Carousel } from 'react-responsive-carousel';
import ImageCarousel from './ImageCarousel';

{/*function Carousel(props) {
    return null;
}*/}

//Carousel.propTypes = {children: PropTypes.node};
export default function CardCar(props) {
    const { offer } = props; // L'offre est dans la prop 'offer'
    const car = offer.car; // Accédez aux propriétés de la voiture dans l'offre
    const images = offer.images; // Accédez aux images de l'offre

    return (
        <div>
            <div className="card-container h-70">
                <div className="row">
                    <div className="col-md-3 mb-4">
                        <div className="card border">
                            <ImageCarousel imageList={images}/>
                            {/*<Carousel showArrows={true}>
                                {images.map((image, index) => (
                                    <div key={index}>
                                        <img src={`/assets/uploadscars/${image.name}`} alt={`Image ${index + 1}`} />
                                    </div>
                                ))}
                                </Carousel>*/}
                                
                                
                        </div>
                            <div className="card-body">
                                <h3 className="card-title">
                                    <a href=""> {offer.offer_title}</a>
                                </h3>
                                <h4 className="card-title"> {car.brand}  {car.model} </h4>
                                <h5 className="card-kilometers">  {car.kilometers}km</h5>
                                <h5 className="card-price">  {car.price}€</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
    )
}



