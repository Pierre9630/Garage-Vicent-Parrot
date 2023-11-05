import React from 'react';
import ReactDOM from 'react-dom';
import images from "core-js/internals/array-iteration";
import * as PropTypes from "prop-types";
//import "react-responsive-carousel/lib/styles/carousel.min.css"; // requires a loader
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Card from 'react-bootstrap/Card';
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
            
            <Card style={{  }}>
                <ImageCarousel imageList={images}/>
                <Card.Body>
                    <Card.Link href={`/offers/show/${offer.id}`}>{offer.offer_title}</Card.Link>
                    <Card.Text>Marque Modèle : </Card.Text>
                    <Card.Text>{car.brand}  {car.model}</Card.Text>
                    <Card.Text> Nombre Portes : </Card.Text>
                    <Card.Text>{car.doors}</Card.Text>
                    <Card.Text> Energie : </Card.Text>
                    <Card.Text>{car.fuel}</Card.Text>
                    <Card.Text> Kilomètres : </Card.Text>
                    <Card.Text>{car.kilometers}km</Card.Text>
                    <Card.Text> Prix : </Card.Text>
                    <Card.Text>{car.price}€</Card.Text>
                </Card.Body>
            </Card>
            {/*<div className="card-container h-70">
                <div className="row">
                    <div className="col-md-3 mb-4">
                        <div className="card border">
                            <ImageCarousel imageList={images}/>                       
                                                                
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
    </div>*/}
    </div>
        
    )
}



