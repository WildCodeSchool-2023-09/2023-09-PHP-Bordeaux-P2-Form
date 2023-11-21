--  SELECT value, label, user_id
-- FROM completed_form
-- JOIN response_session ON response_session.id = completed_form.response_session_id
-- JOIN tool_form ON response_session.tool_form_id = tool_form.id;

-- SELECT * from response_session;

-- SELECT * FROM tool_form
-- JOIN response_session on tool_form.id = response_session.tool_form_id
-- JOIN completed_form on response_session.id = completed_form.response_session_id;

-- SELECT * FROM response_session
-- WHERE user_id = 3;

-- SELECT completed_form.value FROM response_session
-- JOIN completed_form ON response_session.id = completed_form.response_session_id
-- WHERE response_session.tool_form_id = 1; 

/* select response_session.user_id, tool_form.label as question, completed_form.value as response from completed_form
join response_session on completed_form.response_session_id = response_session.id
join tool_form on tool_form.id = response_session.tool_form_id
join form on form.id=tool_form.form_id
where form_id = 1; */

/* SELECT COUNT(DISTINCT response_session.user_id) as nb_responses
FROM response_session
JOIN tool_form ON response_session.tool_form_id = tool_form.id
JOIN form ON form.id = tool_form.form_id
WHERE form.id = 7; */

-- SELECT tool_form.label, tool_input.name AS question_type FROM tool_form
--                     JOIN tool_input ON tool_input.id = tool_form.tool_input_id
--                     WHERE tool_form.form_id = 1;

SELECT count(completed_form.id), completed_form.value FROM completed_form
    JOIN response_session ON response_session.id = completed_form.response_session_id
    JOIN tool_form ON tool_form.id = response_session.tool_form_id
    WHERE tool_form.id = 4
    GROUP BY completed_form.value;

SELECT count(completed_form.id), completed_form.value FROM completed_form
    JOIN response_session ON response_session.id = completed_form.response_session_id
    JOIN tool_form ON tool_form.id = response_session.tool_form_id
    -- LEFT JOIN choice ON choice.tool_form_id = tool_form.id
    WHERE tool_form.id = 11
    GROUP BY completed_form.value;

-- SELECT choice.tool_option, count(completed_form.id) FROM choice
--     JOIN tool_form ON tool_form.id = choice.tool_form_id
--     JOIN response_session ON response_session.tool_form_id = tool_form.id
--     JOIN completed_form ON response_session.id = completed_form.response_session_id
--     WHERE tool_form.id = 4
--     GROUP BY choice.tool_option;

