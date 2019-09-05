import React, { Fragment, useEffect } from 'react';
import { default as MaterialList } from '@material-ui/core/List';
import { makeStyles } from '@material-ui/core/styles';
import ListItem from '@material-ui/core/ListItem';
import Divider from '@material-ui/core/Divider';
import { useStateValue } from '../state';

import fakeData from '../utils/fakePapersAPIResponse.json';
import PaperItem from './PaperItem';

const useStyles = makeStyles(theme => ({
  listItem: {
    flexDirection: 'column',
    alignItems: 'start',
    paddingTop: '16px',
    paddingBottom: '16px',
  },
})
);

const List = () => {
  const classes = useStyles();
  const [{ papersList = [] }, dispatch] = useStateValue();
  const onMount = () => {
    dispatch({
      type: 'fetchPapers',
      payload: fakeData.papers
    })
  }
  useEffect(onMount, []);

  const fakeScore = {
    code: { yes: 60, no: 20, na: 20}, data: { yes: 55, no: 45, na: 0 }, written: { yes: 20, no: 60, na: 20}, structure: { yes: 80, no: 20, na: 0}, tools: { yes: 75, no: 20, na: 5}
  }
  return (
    <MaterialList >
      {
        papersList.map(paper => (
          <Fragment key={paper.id}>
            <ListItem className={classes.listItem}>
              <PaperItem title={paper.title} doi={paper.doi} authors={paper.authors} scores={fakeScore}/>
            </ListItem>
            <Divider component="li" />
          </Fragment>
          )
        )
      }
    </MaterialList>
  )
}

export default List;