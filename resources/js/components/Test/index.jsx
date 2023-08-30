import React, { useState } from 'react'
import { useParams } from 'react-router-dom'
import { tests } from '../utils/index.js'
import ReactDOM from 'react-dom/client'
import styles from './Test.module.scss'
import { differenceInYears, parse } from 'date-fns';
import { resultsService, qualificatorsService } from '../services_new/index'

export const Test = (props) => {
  const [patientName, setPatientName] = useState({ value: '', error: '' })
  const [patientEmail, setPatientEmail] = useState({ value: '', error: '' })
  const [patientAge, setPatientAge] = useState({ value: '', error: '' })
  const [answers, setAnswers] = useState([])

  //Boton disable
  const [enviado, setEnviado] = useState(false);

  const [canSubmit, setCanSubmit] = useState(false)
  console.log(props.id)
  const id = Number(props.id)
  const test = tests.find(test => test.id === id)

  const dateString = props.user.birth_date;
  const date = parse(dateString, 'yyyy-MM-dd', new Date());
  const currentDate = new Date();
  const yearsOld = differenceInYears(currentDate, date);

  console.log(props.user)

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

    const newResult = {
      data: {
        patient_id: props.user.id,
        score: score,
        testResults: testResults,
        appliedTest: id,
      }
    }

    if (id === 1) {
      const status = qualificatorsService.beckDepressionInventory({ score })
      newResult.data.diagnostic = status
    }
    if (id === 2) {
      const indicators = qualificatorsService.derogatisSymptomsInventory({ score, testResults })
      newResult.data.diagnostic = indicators
    }
    if (id === 3) {
      const status = qualificatorsService.beckAnxietyInventory({ score })
      newResult.data.diagnostic = status
    }


    console.log(newResult)
    setCanSubmit(false)
    setEnviado(true)

    resultsService.createResult(newResult).then((res) => {
      console.log(res)
    }).catch((err) => {
      console.error(err)
    })

    setTimeout(() => {
      window.location.href = props.user ? `/patients/${props.user.id}` : '/patients';
    }, 1000);

    var notificationEvent = new Event('notification');
    window.dispatchEvent(notificationEvent);

  }

  return (
    <section className={styles.test}>
      <h1 className={styles.test_title}>Calificador: {test.name}</h1>
      <br />
      <form className={styles.test_form} onSubmit={handleSubmit}>
        <div className={styles.test_form_input}>
          <label htmlFor='patientName'>Nombre del paciente: </label>
          <input disabled
            className='form-control form-control-lg'
            type='text'
            value={props.user.name}
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
          <input disabled
            className='form-control form-control-lg'
            type='text'
            value={props.user.email}
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
          <input disabled
            className='form-control form-control-lg'
            type='text'
            value={yearsOld}
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
  const User = user_data;

  Index.render(
    <React.StrictMode>
      <Test id={idValue} user={User} />
    </React.StrictMode>
  )
}
