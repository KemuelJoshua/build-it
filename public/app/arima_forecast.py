import sys
import numpy as np
import pandas as pd
from statsmodels.tsa.arima.model import ARIMA
import warnings

try:
    # Suppress the specific warning before fitting the model
    warnings.filterwarnings("ignore", message=".*Too few observations.*")
    
    # Parse input values (space-separated string) and convert them to float
    input_data = list(map(float, sys.argv[1:]))  # Convert input arguments into floats

    if not input_data:
        raise ValueError("No data provided")

    # Convert the input data to a pandas series
    series = pd.Series(input_data)

    # Fit the ARIMA model
    model = ARIMA(series, order=(1, 1, 1)) 
    model_fit = model.fit()

    # Forecast the next 5 years (for the next 5 years)
    forecast = model_fit.forecast(steps=10)
    
    # Print the forecast as a comma-separated string
    print(','.join(map(str, forecast)))

except Exception as e:
    print(f"Error: {str(e)}", file=sys.stderr)
    sys.exit(1)  # Exit with a non-zero status to indicate failure
