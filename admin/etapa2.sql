SELECT e.*, de.*, d.*, DATEDIFF(de.to_date, de.from_date) as diastrabalhados FROM employees e 
INNER JOIN dept_emp de ON e.emp_no = de.emp_no
INNER JOIN departments d ON de.dept_no = d.dept_no
WHERE d.dept_no = 'd006'
ORDER BY diastrabalhados DESC limit 10 

-- Para modificar o departamento a ser pesquisado basta trocar 'd006' por outro valor. 