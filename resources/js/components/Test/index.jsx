import React, { useState } from 'react'
import { useParams } from 'react-router-dom'
import { tests } from '../utils/index'
import ReactDOM from 'react-dom/client'
import styles from './Test.module.scss'
import { resultsService } from '../services/index'

export const Test = (props) => {
  const [patientName, setPatientName] = useState({ value: '', error: '' })
  const [patientEmail, setPatientEmail] = useState({ value: '', error: '' })
  const [patientAge, setPatientAge] = useState({ value: '', error: '' })
  const [answers, setAnswers] = useState([])

  //Boton disable
  const [enviado, setEnviado] = useState(false);

  const [canSubmit, setCanSubmit] = useState(false)

  const id = Number(props.id)
  const test = tests.find(test => test.id === id)

  const handleName = (e) => {
    if (!e.target.value) {
      setPatientName({ value: '', error: 'El nombre no puede estar vacío' })
    } else {
      setPatientName({ value: e.target.value, error: '' })
    }
  }

  const handleEmail = (e) => {
    if (!e.target.value) {
      setPatientEmail({ value: '', error: 'El correo electrónico del paciente no puede estar vacío' })
    } else {
      setPatientEmail({ value: e.target.value, error: '' })
    }
  }

  const handleAge = (e) => {
    if (e.target.value) {
      if (isNaN(Number(e.target.value))) {
        setPatientAge({ value: '', error: 'La edad no puede incluír caracteres no numéricos' })
      } else {
        setPatientAge({ value: e.target.value, error: '' })
      }
    } else {
      setPatientAge({ value: '', error: 'La edad no puede estar vacía' })
    }
  }

  const handleChange = (e, index) => {
    setAnswers((prev) => {
      const element = prev.findIndex((el) => el.option === e.target.name)
      if (prev[element]) {
        prev.splice(element, 1)
      }
      const elements = [...prev, { option: e.target.name, value: Number(e.target.value), index }]
      if (elements.length === test.questions.length) {
        setCanSubmit(true)
      } else {
        setCanSubmit(false)
      }
      return elements
    })
  }

  const handleSubmit = (e) => {
    e.preventDefault()
    const score = answers.reduce((acc, curr) => acc + curr.value, 0)
    const testResults = answers.sort((a, b) => a.index - b.index)
    let status = ''
    if (id === 1) {
      if (score <= 13) status = 'Depresión mínima'
      if (score > 13 && score <= 19) status = 'Depresión leve'
      if (score > 19 && score <= 28) status = 'Depresión moderada'
      if (score > 28 && score <= 63) status = 'Depresión grave'
    }
    if (id === 2) {
      console.log('2')
    }
    if (id === 3) {
      console.log('3')
    }

    const newResult = {
      data: {
        name: patientName.value,
        email: patientEmail.value,
        age: patientAge.value,
        score: score,
        testResults: testResults,
        appliedTest: id,
        status: status
      }
    }

    resultsService.createResult(newResult).then((res) => {
      console.log(res)
    }).catch((err) => {
      console.error(err)
    })

    setCanSubmit(false)
    setEnviado(true);

    var notificationEvent = new Event('notification');
    window.dispatchEvent(notificationEvent);

  }

  return (
    <section className={styles.test}>
      <h1 className={styles.test_title}>Calificador: {test.name}</h1>

      <form className={styles.test_form} onSubmit={handleSubmit}>
        <div className={styles.test_form_input}>
          <label htmlFor='patientName'>Nombre del paciente: </label>
          <input
            type='text'
            value={patientName.value}
            required
            onChange={handleName}
            name='patientName'
            id='patientName'
            placeholder='Nombre'
            onBlur={handleName}
          />
          {patientName.error && <p className={styles.test_form_input_error}>{patientName.error}</p>}
        </div>
        <div className={styles.test_form_input}>
          <label htmlFor='patientEmail'>Correo electrónico del paciente: </label>
          <input
            type='text'
            value={patientEmail.value}
            required
            onChange={handleEmail}
            name='patientEmail'
            id='patientEmail'
            placeholder='Correo electrónico'
            onBlur={handleEmail}
          />
          {patientEmail.error && <p className={styles.test_form_input_error}>{patientEmail.error}</p>}
        </div>
        <div className={styles.test_form_input}>
          <label htmlFor='patientAge'>Edad del paciente: </label>
          <input
            type='text'
            value={patientAge.value}
            required onChange={handleAge}
            name='patientAge'
            id='patientAge'
            inputMode='numeric'
            placeholder='Edad'
            onBlur={handleAge}
          />
          {patientAge.error && <p className={styles.test_form_input_error}>{patientAge.error}</p>}
        </div>
        {test.questions && test.questions.map((question) => {
          return (
            <div className={styles.test__form_question} key={question.question}>
              <h3 className={styles.test_form_question_title}>{question.question}</h3>
              <div className={styles.test_form_question_answers}>
                {question.answers.map((answer) => {
                  return (
                    <div className={styles.test_form_question_answers_container} key={answer.option}>
                      <input disabled={enviado}
                        type='radio'
                        name={question.question}
                        id={`${question.question} ${answer.option}`}
                        value={answer.value}
                        className={styles.test_form_question_answers_container_input}
                        onChange={(e) => handleChange(e, question.index)}
                      />
                      <label className={styles.test_form_question_answers_container_label} htmlFor={answer.option}>{answer.option}</label>
                    </div>
                  )
                })}
              </div>
            </div>
          )
        })}
        <button className="btn btn-lg btn-primary" disabled={!canSubmit}>
          {enviado ? 'Formulario enviado' : 'Calificar prueba'}
        </button>
      </form>
    </section>
  )
}

if (document.getElementById('test')) {
  const elementReact = document.getElementById('test');
  const Index = ReactDOM.createRoot(document.getElementById("test"));
  const idValue = elementReact.getAttribute('data-id');

  Index.render(
    <React.StrictMode>
      <Test id={idValue} />
    </React.StrictMode>
  )
}
