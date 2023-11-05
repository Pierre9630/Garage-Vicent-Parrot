import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import CardCar from './CardCar';
import FormCar from './FormCar';
import { Col, Container, Row } from 'react-bootstrap';

export default function App() {
  const [listCar, setListCar] = useState([]);
  const [othersLinkParam, setApiEnpoint] = useState("/api/offers?"); 
  const [searchString, setSearchString] = useState({
    link: apiEndpoint + othersLinkParam,
    offer_title: '',
    reference: '',
    price: 0,
    kilometers: 0,
    year: 0
  });

  const getData = async (filters) => {
    console.log("filtres : " + filters.title);

    let referenceParam = '';

    if (filters.reference.trim() !== "") {
      referenceParam = `&reference=${filters.reference}`;
    }

    const newSearchString = {
      ...searchString,
      offer_title: `offer_title=${filters.title}`,
      reference: referenceParam,
      price: `&car.price[gte]=${filters.priceRange[0]}&car.price[lte]=${filters.priceRange[1]}`,
      kilometers: `&car.kilometers[gte]=${filters.kilometersRange[0]}&car.kilometers[lte]=${filters.kilometersRange[1]}`,
      year: `&car.year[gte]=${filters.yearRange[0]}&car.year[lte]=${filters.yearRange[1]}`
    };

    setSearchString(newSearchString);

    let response = await fetch(`${newSearchString.link}${newSearchString.offer_title}${newSearchString.reference}${newSearchString.price}${newSearchString.kilometers}${newSearchString.year}`);
    let data = await response.json();
    setListCar(data["hydra:member"]);

    return data["hydra:member"];
  }

  useEffect(() => {
    // Vous pouvez activer le fetch ici si nécessaire lors du chargement initial
    getData({ title: '', reference: '', priceRange: [0, 1000000], kilometersRange: [0, 1000000], yearRange: [0, 3000] });
  }, []);

  return (
    <div>
      <Container>
        <Row>
          <Col mb={2}>
            <FormCar onSubmit={getData} />
          </Col>
          
        </Row>
      </Container>
      
      <Container>
        <Row md={3} xs={1} >
        
          {listCar.map(offer => (<Col mb={3} className="mb-1" key={offer.id}><CardCar offer={offer}  /></Col>))}
        
        </Row>
      </Container>
      
    </div>
  )
}
