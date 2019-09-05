import React, { useState, useEffect } from 'react';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import InputBase from '@material-ui/core/InputBase';
import { fade, makeStyles } from '@material-ui/core/styles';
import SearchIcon from '@material-ui/icons/Search';

import { useStateValue } from '../state';
import useDebounce from '../utils/useDebounce';
import fakePapersAPIResponse from '../utils/fakePapersAPIResponse.json';

const useStyles = makeStyles(theme => ({
  root: {
    flexGrow: 1,
    marginBottom: '92px',
  },
  appbar: {
    backgroundColor: '#FFF',
    boxShadow: '0px 2px 4px -1px rgba(0,0,0,0.1), 0px 4px 5px 0px rgba(0,0,0,0.0), 0px 1px 10px 0px rgba(0,0,0,0.06)'
  },
  menuButton: {
    marginRight: theme.spacing(2),
  },
  title: {
    flexGrow: 1,
    display: 'none',
    [theme.breakpoints.up('sm')]: {
      display: 'flex',
      alignContent: 'center'
    },
  },
  search: {
    color: 'rgba(0, 0, 0, 0.87)',
    position: 'relative',
    border: `1px solid #cbcbcb`,
    borderRadius: '20px',
    marginLeft: 0,
    width: '100%',
    [theme.breakpoints.up('sm')]: {
      marginLeft: theme.spacing(1),
      width: 'auto',
    },
  },
  searchIcon: {
    width: theme.spacing(7),
    color: '#303030',
    height: '100%',
    position: 'absolute',
    pointerEvents: 'none',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
  },
  inputRoot: {
    color: 'inherit',
  },
  inputInput: {
    padding: theme.spacing(1, 1, 1, 7),
    transition: theme.transitions.create('width'),
    width: '100%',
    [theme.breakpoints.up('sm')]: {
      width: 120,
      '&:focus': {
        width: 200,
      },
    },
  },
}));

const NavBar = () => {
  const classes = useStyles();
  const [searchTerm, setSearchTerm] = useState('');
  const [ , dispatch] = useStateValue();

  const debouncedSearchTerm = useDebounce(searchTerm, 500);
  const effect = () => {
    if (debouncedSearchTerm && debouncedSearchTerm.length > 0) {
      const filteredPapers = fakePapersAPIResponse.papers.filter(paper => {
        return `${paper.title} ${paper.doi}`.indexOf(debouncedSearchTerm) > -1;
      });
      dispatch({
        type: "fetchPapers",
        payload: filteredPapers
      })
    } else {
      dispatch({
        type: "fetchPapers",
        payload: fakePapersAPIResponse.papers
      })
    }
  };
  useEffect(
    effect,
    [debouncedSearchTerm]
  );
  return (
    <div className={classes.root}>
      <AppBar position="fixed" className={classes.appbar}>
        <Toolbar>
          <div className={classes.title}>
            <img src="/headerLogo.svg" width="200" height="80"/>
          </div>
          <div className={classes.search}>
            <div className={classes.searchIcon}>
              <SearchIcon />
            </div>
            <InputBase
              placeholder="Search…"
              classes={{
                root: classes.inputRoot,
                input: classes.inputInput,
              }}
              onChange={event => setSearchTerm(event.target.value)}
              inputProps={{ 'aria-label': 'search' }}
            />
          </div>
        </Toolbar>
      </AppBar>
    </div>
  );
}

export default NavBar;