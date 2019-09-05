import React from 'react';
import Typography from '@material-ui/core/Typography';

import './TraitBar.css';

const TraitBar = ({ label, yes = 0, no = 0, na = 0}) => {
  const totalScore = yes + no + na;
  return (
    <div>
      { label && <Typography component="label" variant="body2">{label}</Typography> }
      <div className="trait">
        <div className="trait__bar trait__bar--yes" style={{ width: `${yes}%`}}/>
        <div className="trait__bar trait__bar--no" style={{ width: `${yes + no}%`}}/>
        <div className="trait__bar trait__bar--na" style={{ width: `${totalScore ? totalScore : '100'}%`}}/>
      </div>
    </div>
  )
}

export default TraitBar;