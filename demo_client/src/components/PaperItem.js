import React, { Fragment } from 'react';
import Typography from '@material-ui/core/Typography';
import Link from '@material-ui/core/Link';
import { makeStyles, fade } from '@material-ui/core/styles';
import TraitBar from './TraitBar';
import PopOver from './PopOver';

const useStyles = makeStyles(theme => ({
  panel: {
    padding: theme.spacing(2),
    minWidth: '300px',
  },
  container: {
    color: '#303030',
    width: '100%',
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'center'
  },
  info: {
    display: 'flex',
    flexGrow: '1',
    flexDirection: 'column',
    borderRight: '1px solid ' + fade('#cdcdcd', 0.5) 
  },
  img: {
    marginLeft: '10px'
  },
  title: {
    lineHeight: '1.4',
    marginBottom: '4px'
  },
  authors: {
    marginBottom: '4px'
  },
  doi: {
    color: fade('#303030', '0.8')
  }
})
);

const PaperItem = ({ title, authors, doi, scores = {} }) => {
  const classes = useStyles();
  const { code = {}, data = {}, written = {}, structure = {}, tools = {}} = scores;
  return (
    <Fragment>
      <div className={classes.container}>
        <div className={classes.info}>
          <Link className={classes.title} href="http://rateapaper.nfshost.com/?doi=10.1101%2F684423" color="inherit" variant="h6">{title}</Link>
          <Typography className={classes.authors} variant="body1">{authors}</Typography>
          <Link href={`https://doi.org/${doi}`} className={classes.doi} variant="caption">https://doi.org/{doi}</Link>
        </div>
        <PopOver activator={<img className={classes.img} src="/logo.svg" width={100} height={50}/>}>
          <div className={classes.panel}>
            <Typography variant="h6">OpenScore 0.7</Typography>
            <TraitBar label="Code" yes={code.yes} no={code.no} na={code.na} />
            <TraitBar label="Data set" yes={data.yes} no={data.no} na={data.na} />
            <TraitBar label="Well written" yes={written.yes} no={written.no} na={written.na} />
            <TraitBar label="Well structured" yes={structure.yes} no={structure.no} na={structure.na} />
            <TraitBar label="Open Tools" yes={tools.yes} no={tools.no} na={tools.na} />
          </div>
        </PopOver>
      </div>
    </Fragment>
  )
}

export default PaperItem;