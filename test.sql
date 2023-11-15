SELECT value, label, user_id
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
WHERE user_id = 3;

