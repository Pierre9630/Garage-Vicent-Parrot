import React, {useState, useEffect} from 'react';
import ReactDOM from 'react-dom';
import Slider from '@mui/material/Slider';
import Typography from '@mui/material/Typography';
import TextField from '@mui/material/TextField';
import Button from '@mui/material/Button';

export default function FormCar(props) {

  let { onSubmit } = props; 

  useEffect(() => {
    console.log(onSubmit); 
  })

  const [filters, setFilter] = useState({
    title: "",
    priceRange: [0,1000000],
    kilometersRange:[0,1000000],
    yearRange:[1900,2040],
    reference:""
  })

  
  const handlePriceChange = (event, newValue) => {
    
    // formulaire controllé 
    //console.log(newValue); 
    // on modifie le state 
    setFilter({...filters, priceRange: newValue}); 
  };
  
  const handleKilometersChange = (event, newValue) => {
    
    // formulaire controllé 
    //console.log(newValue); 
    // on modifie le state 
    setFilter({...filters, kilometersRange: newValue}); 
  }; 

  const handleYearChange = (event, newValue) => {
    
    // formulaire controllé 
    console.log(newValue); 
    // on modifie le state 
    setFilter({...filters, yearRange: newValue}); 
  }; 

  const handleTitleChange = (event) => {
    
    const newValue = event.target.value; // Obtenez la nouvelle valeur du champ de texte
    setFilter({ ...filters, title: newValue });
  }; 

  const handleReferenceChange = (event) => {
    
    const newValue = event.target.value; // Obtenez la nouvelle valeur du champ de texte
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
        Fourchette des prix
      </Typography>
      <Slider
        value={filters.priceRange}
        onChange={handlePriceChange}
        //onChangeCommitted={handleSubmitChange}
        valueLabelDisplay="auto"
        aria-labelledby="price-range-slider"
        step={500}
        min={500}
        max={100000}
      />
      <Slider
        value={filters.kilometersRange}
        onChange={handleKilometersChange}
        //onChangeCommitted={handleSubmitChange}
        valueLabelDisplay="auto"
        aria-labelledby="kilometers-range-slider"
        step={10000}
        min={500}
        max={100000}
      />
      <Slider
        value={filters.yearRange}
        onChange={handleYearChange}
        //onChangeCommitted={handleSubmitChange}
        valueLabelDisplay="auto"
        aria-labelledby="year-range-slider"
        step={1}
        min={1900}
        max={2040}
      />         
      <Button
      variant="contained"
      sx={{
        bgcolor: '#262526',
        boxShadow: 1,
        borderRadius: 2,
        p: 2,
        minWidth: 80,
      }}
      onClick={handleSubmitChange}     
      >Rechercher</Button>
    </div>
  )
}


