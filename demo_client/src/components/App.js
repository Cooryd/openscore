import React from 'react';
import Container from '@material-ui/core/Container';
import { makeStyles, createMuiTheme } from '@material-ui/core/styles';
import { ThemeProvider } from '@material-ui/styles';
import { StateProvider } from '../state';
import NavBar from './NavBar';
import List from './List'
import './App.css';

const useStyles = makeStyles(theme => ({
    container: {
      maxWidth: '1024px'
    }
  })
);

const theme = createMuiTheme({
  typography: {
    fontFamily: "'Montserrat', sans-serif",
  },
})

function App() {
  const classes = useStyles();
  const initialState = {
    papersList: []
  }
  const reducer = (state, action) => {
    switch (action.type) {
      case 'fetchPapers':
        return {
          ...state,
          papersList: action.payload
        };
        
      default:
        return state;
    }
  }
  return (
    <ThemeProvider theme={theme}>
      <StateProvider initialState={initialState} reducer={reducer}>
        <NavBar />
        <Container className={classes.container} maxWidth="sm">
          <List />
        </Container>
      </StateProvider>
    </ThemeProvider>
  );
}

export default App;
