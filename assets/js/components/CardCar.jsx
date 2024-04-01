import React from 'react';
import Card from 'react-bootstrap/Card';
import ImageCarousel from './ImageCarousel';


export default function CardCar(props) {
    const { offer } = props; // offer is in the prop offer L'offre est dans la prop 'offer'
    const car = offer.car; // access to car proprety Accéder aux propriétés de la voiture dans l'offre
    const images = offer.images; // access offer image Accéder aux images de l'offre par la relation

    return (
        <div>

            <Card style={{}}>
                <ImageCarousel imageList={images} />
                <Card.Body>
                    <Card.Link href={`/offers/show/${offer.id}`} className="font-weight-bold">
                        {offer.offer_title}
                    </Card.Link>
                    <Card.Text>
                        <span className="font-weight-bold" style={{ fontSize: '1.2em' }}>{car.brand}</span> {car.model}
                    </Card.Text>
                    <div className="car-details">
                        <div>
                            <strong>Nombre Portes:</strong> {car.doors}
                        </div>
                        <div>
                            <strong>Energie:</strong> {car.typeFuel}
                        </div>
                        <div>
                            <strong>Kilomètres:</strong> {car.kilometers}km
                        </div>
                        <div>
                            <strong>Prix:</strong> {car.price}€
                        </div>
                    </div>
                </Card.Body>
            </Card>
    </div>
        
    )
}



