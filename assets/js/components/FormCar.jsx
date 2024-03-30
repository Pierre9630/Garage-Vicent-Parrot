import React, {useState, useEffect} from 'react';
import Slider from '@mui/material/Slider';
import Typography from '@mui/material/Typography';
import TextField from '@mui/material/TextField';
import Button from 'react-bootstrap/Button';

export default function FormCar(props) {

  let { onSubmit } = props;
    let { maxprice = 150000 } = {};
    let { maxkilometers = 400000 } = {};

  useEffect(() => {
    console.log(onSubmit); 
  })

  const [filters, setFilter] = useState({
    title: "",
    priceRange: [0,maxprice],
    kilometersRange:[0,maxkilometers],
    yearRange:[1900,new Date().getFullYear()],
    reference:""
  })

  
  const handlePriceChange = (event, newValue) => {
    
    // controlled component  formulaire controllé
    //console.log(newValue); 
    // editing the filter on modifie le state de filter
    setFilter({...filters, priceRange: newValue}); 
  };
  
  const handleKilometersChange = (event, newValue) => {
    
    // controlled component formulaire controllé
    //console.log(newValue); 
    // editing the filter on modifie le state
    setFilter({...filters, kilometersRange: newValue}); 
  }; 

  const handleYearChange = (event, newValue) => {
    
    // controlled component formulaire controllé
    console.log(newValue); 
    // editing the filter on modifie le state
    setFilter({...filters, yearRange: newValue}); 
  }; 

  const handleTitleChange = (event) => {
    
    const newValue = event.target.value; // nouvelle valeur champ de texte
    setFilter({ ...filters, title: newValue });
  }; 

  const handleReferenceChange = (event) => {
    
    const newValue = event.target.value; // textfield new value nouvelle valeur du champ de texte
    setFilter({ ...filters, reference: newValue });
  }; 

  const handleSubmitChange = (event, newValue) => {
    console.log("soummission "); 
    onSubmit(filters); 
  }
  return (
    <div>      
      <TextField id="standard-basic" label="Titre de l'annonce" variant="standard"
      onChange={handleTitleChange}
      />
      <TextField id="standard-basic" label="Réference de l'annonce" variant="standard"
      onChange={handleReferenceChange}
      />
      <Typography id="price-range-slider" gutterBottom>
        Fourchette des prix (en €)
      </Typography>
      <Slider
        value={filters.priceRange}
        onChange={handlePriceChange}
        //onChangeCommitted={handleSubmitChange}
        valueLabelDisplay="auto"
        aria-labelledby="price-range-slider"
        step={1000}
        min={0}
        max={maxprice}
      />
      <Typography id="price-range-slider" gutterBottom>
        Fourchette des Kilomètres (en km)
      </Typography>
      <Slider
        value={filters.kilometersRange}
        onChange={handleKilometersChange}
        //onChangeCommitted={handleSubmitChange}
        valueLabelDisplay="auto"
        aria-labelledby="kilometers-range-slider"
        step={10000}
        min={500}
        max={maxkilometers}
      />
      <Typography id="price-range-slider" gutterBottom>
        Fourchette des années
      </Typography>
      <Slider
        value={filters.yearRange}
        onChange={handleYearChange}
        //onChangeCommitted={handleSubmitChange}
        valueLabelDisplay="auto"
        aria-labelledby="year-range-slider"
        step={1}
        min={1900}
        max={new Date().getFullYear()}
      />         
      <Button
      variant="primary"
      
      onClick={handleSubmitChange}     
      >Rechercher</Button>
    </div>

    
  )
}


