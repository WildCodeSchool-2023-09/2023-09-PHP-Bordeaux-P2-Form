SELECT count(completed_form.value), completed_form.value 
    FROM completed_form
    JOIN response_session ON completed_form.response_session_id = response_session.id
    JOIN tool_form ON tool_form.id = response_session.tool_form_id
    WHERE tool_form.label = 'votre style de musique préféré'
    GROUP BY completed_form.value;