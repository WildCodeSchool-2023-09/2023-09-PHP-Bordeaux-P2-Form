/* SELECT value, label, user_id
FROM completed_form
JOIN response_session ON response_session.id = completed_form.response_session_id
JOIN tool_form ON response_session.tool_form_id = tool_form.id;

SELECT * from response_session;

SELECT * FROM tool_form
JOIN response_session on tool_form.id = response_session.tool_form_id
JOIN completed_form on response_session.id = completed_form.response_session_id;

SELECT * FROM response_session
WHERE user_id = 3;

SELECT * FROM response_session
JOIN completed_form ON response_session.id = completed_form.response_session_id
WHERE user_id = 3; */

select response_session.user_id, tool_form.label as question, completed_form.value as response from completed_form
join response_session on completed_form.response_session_id = response_session.id
join tool_form on tool_form.id = response_session.tool_form_id
join form on form.id=tool_form.form_id
where form_id = 1;

/* SELECT COUNT(DISTINCT response_session.user_id) as nb_responses
FROM response_session
JOIN tool_form ON response_session.tool_form_id = tool_form.id
JOIN form ON form.id = tool_form.form_id
WHERE form.id = 7; */